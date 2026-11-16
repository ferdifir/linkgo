<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreVillageProposalRequest;
use App\Http\Requests\UpdateVillageProposalRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\RateLimiter;
use Symfony\Component\HttpFoundation\Response;

class VillageProposalController
{
    public function store(StoreVillageProposalRequest $request, string $slug): JsonResponse
    {
        abort_unless(DB::table('village_pages')->where('slug', $slug)->exists(), 404);

        if (! $this->sameOrigin($request)) {
            return response()->json(['message' => 'Sumber permintaan tidak valid.'], 403);
        }

        $input = $request->validated();
        if (($input['website'] ?? '') !== '') {
            return response()->json([], 204);
        }

        $key = 'public-proposal:'.$slug.':'.$request->ip();
        if (RateLimiter::tooManyAttempts($key, 5)) {
            return response()->json(['message' => 'Batas kiriman usulan tercapai. Coba kembali satu jam lagi.'], 429);
        }
        RateLimiter::hit($key, 3600);

        DB::table('proposals')->insert([
            'village_slug' => $slug,
            'title' => trim($input['title']),
            'location' => trim($input['location']),
            'category' => trim((string) ($input['category'] ?? '')),
            'description' => trim($input['description']),
            'name' => trim((string) ($input['name'] ?? '')),
            'contact' => trim((string) ($input['contact'] ?? '')),
            'status' => 'Masuk',
            'admin_note' => '',
            'created_at' => now()->utc()->toIso8601String(),
        ]);

        return response()->json(['message' => 'Usulan diterima. Terima kasih telah menyampaikan kebutuhan warga.'], 201);
    }

    public function index(Request $request): JsonResponse
    {
        $rows = DB::table('proposals')
            ->where('village_slug', $this->adminVillageSlug($request))
            ->orderByDesc('created_at')
            ->orderByDesc('id')
            ->get();

        $items = $rows->map(fn ($row) => [
            'id' => $row->id,
            'title' => $row->title,
            'location' => $row->location,
            'category' => $row->category,
            'description' => $row->description,
            'name' => $row->name,
            'contact' => $row->contact,
            'status' => $row->status,
            'adminNote' => $row->admin_note,
            'createdAt' => $row->created_at,
            'villageSlug' => $row->village_slug,
        ]);

        return response()->json($items);
    }

    public function update(UpdateVillageProposalRequest $request, int $id): Response
    {
        $slug = $this->adminVillageSlug($request);
        $data = $request->validated();
        abort_unless(DB::table('proposals')->where('id', $id)->where('village_slug', $slug)->exists(), 404);

        DB::table('proposals')->where('id', $id)->where('village_slug', $slug)->update([
            'status' => $data['status'],
            'admin_note' => trim((string) ($data['adminNote'] ?? '')),
        ]);

        return response()->noContent();
    }

    public function destroy(Request $request, int $id): Response
    {
        abort_unless(DB::table('proposals')
            ->where('id', $id)
            ->where('village_slug', $this->adminVillageSlug($request))
            ->delete(), 404);

        return response()->noContent();
    }

    private function adminVillageSlug(Request $request): string
    {
        $slug = (string) ($request->user()?->village_slug ?? '');
        abort_unless($slug !== '', 403);

        return $slug;
    }

    private function sameOrigin(Request $request): bool
    {
        $origin = $request->header('Origin') ?: $request->header('Referer');
        if (! $origin) {
            return false;
        }

        $scheme = strtolower((string) parse_url($origin, PHP_URL_SCHEME));
        $originPort = parse_url($origin, PHP_URL_PORT) ?? ($scheme === 'https' ? 443 : 80);

        return strtolower((string) parse_url($origin, PHP_URL_HOST)) === strtolower($request->getHost())
            && $originPort === $request->getPort()
            && $scheme === $request->getScheme();
    }
}
