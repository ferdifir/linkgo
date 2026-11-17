<style>
.proposal-widget{--deep:#315c46;--green:#315c46;--lime:#aac26a;--line:#dce5da;--muted:#627067;--ink:#20302a;--sans:system-ui,sans-serif;position:fixed;right:24px;bottom:24px;z-index:1000;display:grid;justify-items:end;gap:10px;font-family:inherit;color:var(--ink)}
.proposal-widget { position:fixed;right:24px;bottom:24px;z-index:12;display:grid;justify-items:end;gap:10px }
.proposal-chat-toggle { display:inline-flex;align-items:center;gap:9px;min-height:54px;padding:0 18px;border:0;border-radius:999px;background:var(--deep);color:#f8faee;font:750 14px var(--sans);box-shadow:0 10px 26px #102c2640;cursor:pointer }
.proposal-chat-toggle:hover { background:#205445;transform:translateY(-2px) }
.proposal-chat-toggle svg { color:#fff }
.proposal-chat-panel { width:min(410px,calc(100vw - 32px));height:min(650px,calc(100dvh - 112px));min-height:min(430px,calc(100dvh - 112px));overflow:hidden;display:grid;grid-template-rows:auto auto minmax(0,1fr) auto auto;background:#fff;border:1px solid #d6e1d2;border-radius:17px;box-shadow:0 20px 60px #102c2630 }
.proposal-chat-panel[hidden] { display:none }
.proposal-chat-header { display:flex;align-items:center;justify-content:space-between;gap:12px;padding:14px 16px;background:var(--deep);color:#fff }
.proposal-chat-heading { display:flex;align-items:center;gap:10px }
.proposal-chat-avatar { display:grid;place-items:center;width:39px;height:39px;border-radius:50%;background:var(--lime);color:var(--deep) }
.proposal-chat-avatar svg { width:19px;height:19px }
.proposal-chat-heading strong,.proposal-chat-heading small { display:block }
.proposal-chat-heading strong { font-size:14px }
.proposal-chat-heading small { margin-top:2px;color:#d5e2d3;font-size:11px }
.proposal-chat-close { display:grid;place-items:center;width:36px;height:36px;border:1px solid #ffffff45;border-radius:50%;background:transparent;color:#fff;cursor:pointer }
.proposal-chat-close:hover { background:#ffffff18 }
.proposal-chat-progress { padding:8px 14px;background:#f5f8f2;border-bottom:1px solid var(--line);color:var(--muted);font-size:11px;font-weight:750 }
.proposal-chat-content { display:grid;grid-template-rows:auto minmax(0,1fr);min-height:0 }
.proposal-chat-log { display:flex;flex-direction:column;gap:10px;overflow-y:auto;padding:14px;background:#f7f9f5;overscroll-behavior:contain }
.proposal-chat-bubble { max-width:88%;padding:10px 12px;border-radius:13px;font-size:13px;line-height:1.5;overflow-wrap:anywhere;white-space:pre-wrap }
.proposal-chat-bubble.bot { align-self:start;background:#fff;border:1px solid #e1e8de;border-bottom-left-radius:4px;color:var(--ink) }
.proposal-chat-bubble.user { align-self:end;background:#dce9d4;border-bottom-right-radius:4px;color:#213a2b }
.proposal-chat-bubble.notice { align-self:center;background:#f5f0e3;color:#6f572d;font-size:12px;text-align:center }
.proposal-chat-choice-list { display:grid;gap:8px;margin-top:8px }
.proposal-chat-choice { min-height:46px;padding:10px 12px;border:1px solid #cbd8c7;border-radius:9px;background:#fff;color:var(--green);font:700 13px var(--sans);text-align:left;cursor:pointer }
.proposal-chat-choice:hover,.proposal-chat-choice:focus-visible { border-color:#668461;background:#f0f4ed }
.proposal-chat-summary { display:grid;gap:7px;margin-top:8px }
.proposal-chat-summary div { padding-top:6px;border-top:1px solid var(--line) }
.proposal-chat-summary strong,.proposal-chat-summary span { display:block }
.proposal-chat-summary strong { color:var(--muted);font-size:10px }
.proposal-chat-summary span { margin-top:2px;white-space:pre-wrap;overflow-wrap:anywhere }
.proposal-chat-form { padding:12px 14px 14px;border-top:1px solid var(--line);background:#fff }
.proposal-chat-field { display:grid;gap:6px }
.proposal-chat-field label { color:var(--ink);font-size:12px;font-weight:750 }
.proposal-chat-field input,.proposal-chat-field select,.proposal-chat-field textarea { width:100%;min-height:43px;border:1px solid #aabbaa;border-radius:9px;background:#fff;padding:10px 11px;color:var(--ink);font:500 14px var(--sans) }
.proposal-chat-field textarea { min-height:88px;resize:vertical }
.proposal-chat-field input:focus,.proposal-chat-field select:focus,.proposal-chat-field textarea:focus { outline:3px solid #dbe7cf;border-color:#668461 }
.proposal-chat-actions { display:grid;grid-template-columns:repeat(2,minmax(0,1fr));grid-template-areas:"send cancel" "extra extra";gap:7px;margin-top:10px }
.proposal-chat-actions .button,.proposal-chat-skip,.proposal-chat-edit,.proposal-chat-cancel { display:grid;place-items:center;width:100%;min-height:39px;padding:7px 10px;border:0;border-radius:8px;background:#e8f0e5;color:#315b39;font:700 12px var(--sans);cursor:pointer;box-shadow:none }
.proposal-chat-send { grid-area:send }
.proposal-chat-cancel { grid-area:cancel }
.proposal-chat-skip,.proposal-chat-edit { grid-area:extra }
.proposal-chat-actions .button:hover,.proposal-chat-skip:hover,.proposal-chat-edit:hover { background:#dce9d6 }
@media(max-width:600px){.proposal-widget{right:12px;bottom:max(12px,env(safe-area-inset-bottom))}.proposal-chat-panel{width:min(410px,calc(100vw - 28px));height:min(620px,calc(100dvh - 86px));min-height:min(380px,calc(100dvh - 86px))}.proposal-chat-toggle{width:50px;height:50px;min-height:50px;justify-content:center;padding:0;border-radius:50%}.proposal-chat-toggle svg{width:20px;height:20px}.proposal-chat-toggle span{position:absolute;width:1px;height:1px;overflow:hidden;clip-path:inset(50%);white-space:nowrap}}
.proposal-chat-progress{font-size:14px}
.proposal-chat-bubble{font-size:14px}
.proposal-chat-choice{font-size:14px}
.proposal-chat-field label{font-size:14px}
.proposal-chat-actions .button,.proposal-chat-skip,.proposal-chat-edit,.proposal-chat-cancel,.proposal-chat-restart{font-size:14px}
.proposal-chat-heading strong{font-size:15px}
.proposal-chat-heading small{font-size:13px}
</style>
<div class="proposal-widget">
  <section class="proposal-chat-panel" id="proposal-chat-panel" role="dialog" aria-labelledby="proposal-chat-title" aria-modal="false" hidden>
    <header class="proposal-chat-header">
      <div class="proposal-chat-heading"><span class="proposal-chat-avatar"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M20 11.5a7.5 7.5 0 0 1-7.5 7.5H5l1.7-3.4A7.5 7.5 0 1 1 20 11.5Z"/><path d="M8 11h8M8 14h5"/></svg></span><span><strong id="proposal-chat-title">Kanal warga</strong><small>Layanan, usulan, pengaduan, cek status</small></span></div>
      <button class="proposal-chat-close" id="proposal-chat-close" type="button" aria-label="Tutup formulir"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" aria-hidden="true"><path d="m6 6 12 12M18 6 6 18"/></svg></button>
    </header>
    <p class="proposal-chat-progress" id="proposal-chat-progress">Pilih jenis pengajuan</p>
    <div class="proposal-chat-log" id="proposal-chat-log" role="log" aria-live="polite" aria-relevant="additions text"></div>
    <form class="proposal-chat-form" id="proposal-chat-form" hidden>
      <div class="proposal-chat-field" id="proposal-chat-field"></div>
      <p class="proposal-chat-error" id="proposal-chat-error" role="alert" hidden></p>
      <div class="proposal-chat-actions">
        <button class="button lime proposal-chat-send" id="proposal-chat-send" type="submit">Lanjut</button>
        <button class="proposal-chat-skip" id="proposal-chat-skip" type="button" hidden>Lewati</button>
        <button class="proposal-chat-edit" id="proposal-chat-edit" type="button" hidden>Ubah jawaban</button>
        <button class="proposal-chat-cancel" id="proposal-chat-cancel" type="button">Batal</button>
      </div>
    </form>
    <button class="proposal-chat-restart" id="proposal-chat-restart" type="button">Mulai pengajuan baru</button>
  </section>
  <button class="proposal-chat-toggle" id="proposal-chat-toggle" type="button" aria-label="Buka kanal layanan, aspirasi, dan cek status" aria-expanded="false" aria-controls="proposal-chat-panel"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M20 11.5a7.5 7.5 0 0 1-7.5 7.5H5l1.7-3.4A7.5 7.5 0 1 1 20 11.5Z"/><path d="M8 11h8M8 14h5"/></svg><span>Kanal warga</span></button>
</div>
<script>
document.addEventListener('DOMContentLoaded',()=>{
  const slug=@json(request()->segment(2));
  document.querySelectorAll('.proposal-fab,.proposal-button,#proposal-open,#proposal-chat,#sk-chat-toggle,#sk-chat,button[id$="-chat-toggle"]:not(#proposal-chat-toggle)').forEach(element=>element.remove());
  const widget=document.querySelector('.proposal-widget');
  const palette={
    'banyuanyar-lor':['#24465b','#d27343'],'brumbungan-lor':['#173a34','#d27343'],bulang:['#174eb5','#405c4c'],curahsawo:['#12392f','#e4f2a6'],
    gending:['#234b47','#d6a547'],jatiadi:['#164b38','#d6ed63'],klaseman:['#526b4e','#d1a93a'],
    pajurangan:['#244d3c','#b78742'],pesisir:['#123c49','#6baba3'],pikatan:['#385949','#76a7a0'],
    randupitu:['#365845','#9f3828'],sebaung:['#315c46','#aac26a'],sumberkerang:['#163f43','#4c8983']
  };
  const [deep,accent]=palette[slug]||['#315c46','#aac26a'];
  widget.style.setProperty('--deep',deep);widget.style.setProperty('--green',deep);widget.style.setProperty('--lime',accent);widget.style.setProperty('--line',`${deep}26`);widget.style.setProperty('--muted','#627067');widget.style.setProperty('--ink','#20302a');
  const syncProjectDetailVisibility=()=>{widget.hidden=Boolean(document.querySelector('.sk-project-pop.open,.project-overlay.open'))};
  syncProjectDetailVisibility();
  new MutationObserver(syncProjectDetailVisibility).observe(document.body,{attributes:true,attributeFilter:['class'],childList:true,subtree:true});
  const proposalPanel=document.querySelector('#proposal-chat-panel');
  const proposalToggle=document.querySelector('#proposal-chat-toggle');
  const proposalClose=document.querySelector('#proposal-chat-close');
  const proposalLog=document.querySelector('#proposal-chat-log');
  const proposalForm=document.querySelector('#proposal-chat-form');
  const proposalField=document.querySelector('#proposal-chat-field');
  const proposalProgress=document.querySelector('#proposal-chat-progress');
  const proposalSend=document.querySelector('#proposal-chat-send');
  const proposalSkip=document.querySelector('#proposal-chat-skip');
  const proposalEdit=document.querySelector('#proposal-chat-edit');
  const proposalCancel=document.querySelector('#proposal-chat-cancel');
  const proposalRestart=document.querySelector('#proposal-chat-restart');
  const proposalError=document.querySelector('#proposal-chat-error');
  const proposalStepsByFlow={
    usulan:[
    {name:'title',label:'Judul usulan',prompt:'Apa judul singkat untuk kebutuhan yang ingin disampaikan?',type:'text',required:true,maxLength:160,placeholder:'Contoh: Perbaikan jalan dusun'},
    {name:'category',label:'Jenis kebutuhan',prompt:'Usulan ini termasuk kebutuhan yang mana?',type:'select',required:true,options:['Jalan dan lingkungan','Air dan irigasi','Fasilitas umum','Pelayanan desa','Lainnya']},
    {name:'location',label:'Lokasi',prompt:'Di mana lokasi kebutuhan ini? Sebutkan dusun, RT/RW, atau patokan.',type:'text',required:true,maxLength:160,placeholder:'Dusun, RT/RW, atau patokan'},
    {name:'description',label:'Uraian kebutuhan',prompt:'Ceritakan kebutuhan dan dampaknya bagi warga.',type:'textarea',required:true,maxLength:3000,placeholder:'Jelaskan kondisi saat ini dan siapa yang terdampak.'},
    {name:'name',label:'Nama',prompt:'Siapa nama yang boleh dicantumkan pada usulan?',type:'text',required:false,maxLength:120,placeholder:'Nama Anda (opsional)'},
    {name:'contact',label:'Kontak',prompt:'Apa nomor telepon atau kontak yang bisa dihubungi jika perlu klarifikasi?',type:'text',required:false,maxLength:160,placeholder:'Nomor telepon atau kontak lain (opsional)'}
    ],
    permintaan:[
      {name:'category',label:'Layanan atau kategori',prompt:'Pilih layanan yang diperlukan.',type:'select',required:true,options:[]},
      {name:'title',label:'Judul',prompt:'Beri judul singkat untuk permintaan ini.',type:'text',required:true,maxLength:180,placeholder:'Contoh: Permohonan surat keterangan'},
      {name:'description',label:'Rincian',prompt:'Ceritakan kebutuhan atau pengaduan Anda secara singkat.',type:'textarea',required:true,maxLength:3000,placeholder:'Tambahkan informasi yang membantu pemerintah desa memahami permintaan Anda.'},
      {name:'name',label:'Nama',prompt:'Siapa nama yang dapat dicantumkan?',type:'text',required:false,maxLength:120,placeholder:'Nama Anda (opsional)'},
      {name:'contact',label:'Kontak',prompt:'Nomor telepon atau WhatsApp yang bisa dihubungi untuk tindak lanjut?',type:'text',required:true,maxLength:180,placeholder:'Nomor telepon atau WhatsApp'},
      {name:'email',label:'Email',prompt:'Masukkan email jika ingin menerima pembaruan status melalui email.',type:'email',required:false,maxLength:180,placeholder:'Email (opsional)'}
    ]
  };
  const requestFlowOptions=[
    {value:'usulan',label:'Sampaikan usulan warga'},
    {value:'layanan',label:'Ajukan permohonan layanan'},
    {value:'pengaduan',label:'Sampaikan pengaduan'},
    {value:'cek_status',label:'Cek status permintaan'}
  ];
  let proposalAnswers={};
  let proposalStep=0;
  let proposalFlow=null;
  let proposalSessionStarted=false;
  const currentProposalSteps=()=>{
    if(proposalFlow==='cek_status')return [{name:'trackingCode',label:'Kode tiket',prompt:'Masukkan kode tiket 10 karakter untuk melihat status permintaan.',type:'text',required:true,maxLength:10,pattern:'[A-Za-z0-9]{10}',placeholder:'Contoh: A1B2C3D4E5'}];
    const steps=proposalFlow==='usulan'?proposalStepsByFlow.usulan:[...proposalStepsByFlow.permintaan];
    if(proposalFlow!=='usulan'&&proposalAnswers.email)steps.push({name:'notifyByEmail',label:'Pembaruan email',prompt:'Izinkan pemerintah desa mengirim pembaruan status ke email tersebut?',type:'select',required:true,options:[['1','Ya, kirim pembaruan'],['0','Tidak']]});
    return steps;
  };
  const loadServiceOptions=async()=>{
    try{
      const response=await fetch(`/api/desa/${encodeURIComponent(slug)}/managed-content`,{headers:{'Accept':'application/json'}});
      if(!response.ok)return ['Administrasi kependudukan','Surat keterangan','Informasi layanan','Lainnya'];
      const data=await response.json();
      const services=Array.isArray(data.services)?data.services.map(service=>service.title).filter(Boolean):[];
      return services.length?services:['Administrasi kependudukan','Surat keterangan','Informasi layanan','Lainnya'];
    }catch{return ['Administrasi kependudukan','Surat keterangan','Informasi layanan','Lainnya']}
  };
  const appendChatMessage=(text,kind='bot')=>{
    const bubble=document.createElement('div');bubble.className=`proposal-chat-bubble ${kind}`;bubble.textContent=text;proposalLog.append(bubble);proposalLog.scrollTop=proposalLog.scrollHeight;return bubble;
  };
  const closeProposalChat=()=>{proposalPanel.hidden=true;proposalToggle.setAttribute('aria-expanded','false');proposalToggle.focus()};
  const renderFlowChoice=()=>{
    proposalProgress.textContent='Pilih jenis pengajuan';proposalForm.hidden=false;proposalField.hidden=false;proposalField.replaceChildren();proposalError.hidden=true;proposalSkip.hidden=true;proposalEdit.hidden=true;proposalSend.hidden=true;
    appendChatMessage('Apa yang ingin Anda sampaikan?');
    const choices=document.createElement('div');choices.className='proposal-chat-choice-list';
    requestFlowOptions.forEach(option=>{
      const button=document.createElement('button');button.type='button';button.className='proposal-chat-choice';button.textContent=option.label;
      button.addEventListener('click',async()=>{
        if(option.value==='cek_status'){
          proposalFlow='cek_status';proposalAnswers={kind:option.value};appendChatMessage(option.label,'user');proposalStep=0;proposalSend.hidden=false;renderProposalStep();return;
        }
        proposalFlow=option.value==='usulan'?'usulan':'permintaan';
        proposalAnswers.kind=option.value;
        if(proposalFlow==='permintaan'){
          proposalStepsByFlow.permintaan[0].options=option.value==='layanan'?await loadServiceOptions():['Pelayanan desa','Infrastruktur dan lingkungan','Sosial dan ekonomi','Keamanan dan ketertiban','Lainnya'];
        }
        appendChatMessage(option.label,'user');proposalStep=0;proposalSend.hidden=false;renderProposalStep();
      });
      choices.append(button);
    });
    proposalField.append(choices);
  };
  const renderProposalStep=()=>{
    const steps=currentProposalSteps(),step=steps[proposalStep];
    proposalProgress.textContent=`Pertanyaan ${proposalStep+1} dari ${steps.length}`;
    proposalForm.hidden=false;proposalField.hidden=false;proposalField.replaceChildren();proposalError.hidden=true;proposalSkip.hidden=step.required;proposalEdit.hidden=true;
    proposalSend.textContent=proposalFlow==='cek_status'?'Cek status':proposalStep===steps.length-1?'Tinjau':'Lanjut';
    appendChatMessage(step.prompt);
    const label=document.createElement('label');label.htmlFor=`proposal-answer-${step.name}`;label.textContent=step.required?step.label:`${step.label} (opsional)`;
    let input;
    if(step.type==='select'){
      input=document.createElement('select');
      const placeholder=document.createElement('option');placeholder.value='';placeholder.textContent='Pilih salah satu';placeholder.disabled=true;placeholder.selected=true;input.append(placeholder);
      step.options.forEach(option=>{const value=Array.isArray(option)?option[0]:option,text=Array.isArray(option)?option[1]:option;const item=document.createElement('option');item.value=value;item.textContent=text;input.append(item)});
    } else if(step.type==='textarea') input=document.createElement('textarea');
    else {input=document.createElement('input');input.type='text';}
    input.id=`proposal-answer-${step.name}`;input.name=step.name;input.maxLength=step.maxLength;input.required=step.required;
    if(step.pattern)input.pattern=step.pattern;
    if(step.placeholder)input.placeholder=step.placeholder;
    input.value=proposalAnswers[step.name]||'';
    proposalField.append(label,input);
    input.focus();
  };
  const showProposalReview=()=>{
    const steps=currentProposalSteps(),isRequest=proposalFlow==='permintaan';
    proposalProgress.textContent='Periksa sebelum dikirim';proposalForm.hidden=false;proposalField.hidden=true;proposalError.hidden=true;proposalSkip.hidden=true;proposalEdit.hidden=false;proposalSend.textContent=isRequest?'Kirim permintaan':'Kirim usulan';
    appendChatMessage('Periksa kembali informasi berikut sebelum dikirim.');
    const summary=appendChatMessage('');
    const list=document.createElement('div');list.className='proposal-chat-summary';
    const flowRow=document.createElement('div');const flowHeading=document.createElement('strong');flowHeading.textContent='Jenis pengajuan';const flowValue=document.createElement('span');flowValue.textContent=requestFlowOptions.find(option=>option.value===proposalAnswers.kind)?.label||'';flowRow.append(flowHeading,flowValue);list.append(flowRow);
    steps.forEach(step=>{const row=document.createElement('div');const heading=document.createElement('strong');heading.textContent=step.label;const value=document.createElement('span');value.textContent=step.name==='notifyByEmail'?(proposalAnswers.notifyByEmail==='1'?'Ya, kirim pembaruan':'Tidak'):(proposalAnswers[step.name]||'Tidak diisi');row.append(heading,value);list.append(row)});
    summary.append(list);
  };
  const startProposalChat=()=>{
    proposalAnswers={};proposalStep=0;proposalFlow=null;proposalSessionStarted=true;proposalLog.replaceChildren();proposalForm.hidden=false;proposalRestart.style.display='none';proposalToggle.setAttribute('aria-expanded','true');proposalPanel.hidden=false;renderFlowChoice();
  };
  proposalToggle.addEventListener('click',()=>{
    if(proposalPanel.hidden){if(!proposalSessionStarted)startProposalChat();else{proposalPanel.hidden=false;proposalToggle.setAttribute('aria-expanded','true');const input=proposalPanel.querySelector('.proposal-chat-field input,.proposal-chat-field select,.proposal-chat-field textarea');if(input&&!proposalForm.hidden)input.focus()}}
    else closeProposalChat();
  });
  proposalClose.addEventListener('click',closeProposalChat);
  document.addEventListener('keydown',event=>{if(event.key==='Escape'&&!proposalPanel.hidden)closeProposalChat()});
  proposalForm.addEventListener('submit',async event=>{
    event.preventDefault();
    const steps=currentProposalSteps();
    if(proposalFlow==='cek_status'){
      const input=proposalField.querySelector('input');
      if(!input.reportValidity())return;
      const trackingCode=input.value.trim();proposalAnswers.trackingCode=trackingCode;appendChatMessage(trackingCode,'user');
      proposalSend.disabled=true;proposalError.hidden=true;proposalSend.textContent='Memeriksa…';
      try{
        const response=await fetch(`/api/desa/${encodeURIComponent(slug)}/requests/${encodeURIComponent(trackingCode)}`,{headers:{'Accept':'application/json'}});
        const result=await response.json();
        if(!response.ok)throw new Error(result.message||'Status permintaan belum dapat ditampilkan.');
        appendChatMessage(`${result.title} · Status: ${result.status} · Diperbarui ${result.updatedAt}`);
        if(Array.isArray(result.history)&&result.history.length)appendChatMessage(`Riwayat status: ${result.history.map(entry=>entry.status).join(' > ')}`,'notice');
        proposalProgress.textContent='Status permintaan';proposalForm.hidden=true;proposalRestart.style.display='block';
      }catch(error){proposalError.textContent=error.message;proposalError.hidden=false;proposalSend.textContent='Coba lagi';input.focus()}
      finally{proposalSend.disabled=false;}
      return;
    }
    if(proposalStep<steps.length){
      const step=steps[proposalStep],input=proposalField.querySelector('input,select,textarea');
      if(!input.reportValidity())return;
      const value=input.value.trim();if(step.required&&!value){input.focus();return}
      proposalAnswers[step.name]=value;appendChatMessage(value||'—','user');proposalStep++;
      if(proposalStep<currentProposalSteps().length)renderProposalStep();else showProposalReview();
      return;
    }
    proposalSend.disabled=true;proposalError.hidden=true;proposalSend.textContent='Mengirim…';
    try{
      const isRequest=proposalFlow==='permintaan',endpoint=isRequest?`/api/desa/${encodeURIComponent(slug)}/requests`:`/api/desa/${encodeURIComponent(slug)}/proposals`;
      const payload=isRequest?{...proposalAnswers,kind:proposalAnswers.kind,website:''}:{...proposalAnswers,website:''};
      const response=await fetch(endpoint,{method:'POST',headers:{'Content-Type':'application/json','Accept':'application/json'},body:JSON.stringify(payload)});
      if(!response.ok){const body=(await response.text()).trim();let message=body;try{message=JSON.parse(body).message||body}catch{}throw new Error(message||'Usulan belum terkirim. Coba lagi.')}
      const result=response.status===204?{}:await response.json();appendChatMessage(result.message||(isRequest?'Permintaan diterima.':'Usulan diterima. Terima kasih telah menyampaikan kebutuhan warga.'));
      if(result.trackingCode)appendChatMessage(`Kode tiket: ${result.trackingCode}. Simpan kode ini untuk memeriksa tindak lanjut.`,'notice');
      proposalProgress.textContent='Pengajuan terkirim';proposalForm.hidden=true;proposalRestart.style.display='block';proposalAnswers={};proposalSessionStarted=true;
    }catch(error){proposalError.textContent=error.message;proposalError.hidden=false;proposalSend.textContent='Coba kirim lagi';}
    finally{proposalSend.disabled=false;}
  });
  proposalSkip.addEventListener('click',()=>{
    const step=currentProposalSteps()[proposalStep];if(!step||step.required)return;
    proposalAnswers[step.name]='';appendChatMessage('Lewati','user');proposalStep++;
    if(proposalStep<currentProposalSteps().length)renderProposalStep();else showProposalReview();
  });
  proposalEdit.addEventListener('click',()=>{appendChatMessage('Mari periksa kembali jawaban dari awal.');proposalStep=0;renderProposalStep()});
  proposalCancel.addEventListener('click',()=>{
    proposalAnswers={};proposalStep=0;proposalFlow=null;proposalForm.hidden=true;proposalError.hidden=true;proposalRestart.style.display='block';proposalProgress.textContent='Pengajuan dibatalkan';appendChatMessage('Pengajuan dibatalkan. Tidak ada data yang dikirim.','notice');
  });
  proposalRestart.addEventListener('click',startProposalChat);
});
</script>
