#!/usr/bin/env bash
set -euo pipefail

SSH_HOST="${SSH_HOST:-root@109.111.53.58}"
SSH_PORT="${SSH_PORT:-38954}"
REMOTE_DIR="${REMOTE_DIR:-/var/www/linkgo}"
BRANCH="${DEPLOY_BRANCH:-main}"

PROJECT_DIR="$(git rev-parse --show-toplevel 2>/dev/null)" || {
    printf 'Jalankan script dari dalam repository Git.\n' >&2
    exit 1
}

cd "$PROJECT_DIR"

if [[ "$(git branch --show-current)" != "$BRANCH" ]]; then
    printf 'Deploy hanya bisa dijalankan dari branch %s.\n' "$BRANCH" >&2
    exit 1
fi

if [[ -n "$(git status --porcelain)" ]]; then
    printf 'Working tree lokal belum bersih. Commit atau simpan perubahan sebelum deploy.\n' >&2
    git status --short >&2
    exit 1
fi

printf 'Mengirim commit %s ke origin/%s...\n' "$(git rev-parse --short HEAD)" "$BRANCH"
git push origin "$BRANCH"

printf 'Memperbarui %s di %s...\n' "$REMOTE_DIR" "$SSH_HOST"
ssh -p "$SSH_PORT" "$SSH_HOST" bash -s -- "$REMOTE_DIR" "$BRANCH" <<'REMOTE_SCRIPT'
set -euo pipefail

remote_dir="$1"
branch="$2"

if [[ ! -d "$remote_dir/.git" ]]; then
    printf 'Repository Git tidak ditemukan di %s.\n' "$remote_dir" >&2
    exit 1
fi

cd "$remote_dir"
if [[ "$(git branch --show-current)" != "$branch" ]]; then
    printf 'Checkout server bukan branch %s.\n' "$branch" >&2
    exit 1
fi

git fetch origin "$branch"
if ! git merge-base --is-ancestor HEAD "origin/$branch"; then
    printf 'Branch server tidak bisa diperbarui dengan fast-forward dari origin/%s.\n' "$branch" >&2
    exit 1
fi

dirty_paths="$( { git diff --name-only HEAD; git ls-files --others --exclude-standard; } | sort -u )"
if [[ -n "$dirty_paths" ]]; then
    while IFS= read -r path; do
        if ! git cat-file -e "origin/$branch:$path" 2>/dev/null \
            || ! cmp -s -- "$path" <(git show "origin/$branch:$path"); then
            printf 'Perubahan server berbeda dari origin/%s: %s\n' "$branch" "$path" >&2
            git status --short >&2
            exit 1
        fi
    done <<< "$dirty_paths"

    while IFS= read -r path; do
        if git ls-files --error-unmatch "$path" >/dev/null 2>&1; then
            git restore --source=HEAD --staged --worktree -- "$path"
        else
            rm -- "$path"
        fi
    done <<< "$dirty_paths"
fi

if [[ -n "$(git status --porcelain)" ]]; then
    printf 'Working tree server belum bersih; deploy dihentikan agar perubahan server tidak tertimpa.\n' >&2
    git status --short >&2
    exit 1
fi

git pull --ff-only origin "$branch"
php artisan optimize:clear
php artisan view:cache
REMOTE_SCRIPT

printf 'Deploy selesai.\n'
