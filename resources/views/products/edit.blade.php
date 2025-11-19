@extends('layouts.app')

@section('content')
    <div class="product-create-wrap">
        <a href="{{ url()->previous() }}">&larr; Kembali</a>

        @if($errors->any())
            <div style="background:#f8d7da;color:#842029;padding:10px;border-radius:8px;margin:10px 0">
                <ul style="margin:0;padding-left:18px">@foreach($errors->all() as $err)<li>{{ $err }}</li>@endforeach</ul>
            </div>
        @endif

        <form action="{{ route('products.update', $product->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="field">
                <div class="row">
                    <div class="label-box">Nama Produk :</div>
                    <div class="input-area"><input type="text" name="name" value="{{ old('name', $product->name) }}" placeholder="" required></div>
                </div>
            </div>

            <div class="field">
                <div class="row">
                    <div class="label-box">Harga :</div>
                    <div class="input-area"><input type="text" name="price" value="{{ old('price', $product->price) }}" placeholder=""></div>
                </div>
            </div>

            <div class="field">
                <div class="row">
                    <div class="label-box" style="min-width:96px;align-self:flex-start">Deskripsi :</div>
                    <div class="input-area"><textarea name="description" placeholder="">{{ old('description', $product->description) }}</textarea></div>
                </div>
            </div>

            <div class="field">
                <div class="row">
                    <div class="label-box">Varian :</div>
                    <div class="input-area">
                        <div class="variants-row">
                            <input id="variantInput" class="variant-input" type="text" placeholder="Varian :">
                            <button type="button" class="btn-ghost" onclick="addVariantFromInput()">Tambah</button>
                        </div>
                        <div id="variants" class="chips">
                            @if(!empty($product->variants) && is_array($product->variants))
                                @foreach($product->variants as $v)
                                    <div class="chip">
                                        <span>{{ $v }}</span>
                                        <input type="hidden" name="variants[]" value="{{ $v }}">
                                        <span class="x" onclick="removeVariant(this)">X</span>
                                    </div>
                                @endforeach
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <div class="field">
                <div class="row">
                    <div class="label-box">Imput Gambar :</div>
                    <div class="input-area">
                        <div style="display:flex;gap:8px">
                            <button type="button" class="btn-ghost" onclick="document.getElementById('imageFile').click()">ubah gambar</button>
                            <input id="imageFile" type="file" name="image" accept="image/*" style="display:none">
                        </div>
                        <div class="image-box" id="previewBox">
                            @if($product->image)
                                <img id="previewImg" src="{{ asset('images/' . $product->image) }}" alt="preview" style="max-height:180px; max-width:100%; object-fit:contain">
                                <div id="previewPlaceholder" style="display:none"></div>
                            @else
                                <img id="previewImg" src="" alt="preview" style="display:none; max-height:180px; max-width:100%; object-fit:contain">
                                <div id="previewPlaceholder" style="color:#666;display:flex;align-items:center;justify-content:center;">
                                    <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                                        <rect x="1" y="3" width="22" height="18" rx="3" fill="#555" opacity="0.12" />
                                        <circle cx="8" cy="8" r="2" fill="#555" opacity="0.6" />
                                        <path d="M3 19l5-6 4 5 6-8 3 5" stroke="#555" stroke-width="1.2" stroke-linecap="round" stroke-linejoin="round" opacity="0.7" fill="none"/>
                                    </svg>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <div style="margin-top:12px">
                <button type="submit" class="btn-submit">PERBARUI PRODUK</button>
            </div>
        </form>
    </div>

    <script>
        function escapeHtml(unsafe){ return String(unsafe).replace(/[&<>"']/g,function(m){return({'&':'&amp;','<':'&lt;','>':'&gt;','"':'&quot;',"'":"&#39;"})[m];}); }
        function escapeAttr(s){ return String(s).replace(/"/g,'&quot;'); }

        function createVariantChip(value){
            const chip = document.createElement('div');
            chip.className = 'chip';
            chip.innerHTML = '<span>'+escapeHtml(value)+'</span>' +
                '<input type="hidden" name="variants[]" value="'+escapeAttr(value)+'">' +
                '<span class="x" onclick="removeVariant(this)">X</span>';
            return chip;
        }

        function addVariantFromInput(){
            const input = document.getElementById('variantInput');
            const v = (input.value||'').trim();
            if(!v) return;
            const existing = Array.from(document.querySelectorAll('#variants input[name="variants[]"]')).map(i=>i.value);
            if(existing.includes(v)) { input.value=''; input.focus(); return; }
            document.getElementById('variants').appendChild(createVariantChip(v));
            input.value = ''; input.focus();
        }

        function removeVariant(el){ const chip = el.closest('.chip'); if(chip) chip.remove(); }

        document.addEventListener('DOMContentLoaded', function(){
            const iv = document.getElementById('variantInput');
            if(iv) iv.addEventListener('keydown', function(e){ if(e.key === 'Enter'){ e.preventDefault(); addVariantFromInput(); } });

            const file = document.getElementById('imageFile');
            if(file) file.addEventListener('change', function(e){
                const f = e.target.files[0];
                const img = document.getElementById('previewImg');
                const ph = document.getElementById('previewPlaceholder');
                if(f){
                    const url = URL.createObjectURL(f);
                    img.src = url; img.style.display = 'block'; if(ph) ph.style.display = 'none';
                } else { if(img){ img.src=''; img.style.display='none'; } if(ph) ph.style.display='flex'; }
            });
        });
    </script>

    <style>
        /* Reuse create page styling for pixel match */
        .product-create-wrap{ width:360px; max-width:96%; margin:6px auto; padding:6px; font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial }
        .field{ margin-bottom:12px }
        /* Use a two-column grid per row: fixed label, flexible input */
        .field .row{ display:grid; grid-template-columns: 120px 1fr; gap:12px; align-items:start }
        .label-box{ background:#e6e6e6; padding:8px 10px; border-radius:8px; min-width:110px; color:#222; font-size:13px; box-shadow: inset 0 -2px 0 rgba(0,0,0,0.03) }
        .input-area{ margin-left:10px; flex:1; background:#e6e6e6; padding:8px 12px; border-radius:8px }
        .input-area input[type=text], .input-area textarea{ background:transparent;border:0;width:100%;outline:none;font-size:14px;color:#111 }
        .input-area textarea{ min-height:140px; resize:vertical }
        .label-box{ background:#e6e6e6; padding:8px 10px; border-radius:8px; color:#222; font-size:13px; box-shadow: inset 0 -2px 0 rgba(0,0,0,0.03); width:120px; box-sizing:border-box }
        .input-area{ margin:0; display:block; background:#e6e6e6; padding:8px 12px; border-radius:8px; min-width:0 }
        .input-area textarea{ height:140px; align-items:flex-start; padding-top:12px; width:100%; box-sizing:border-box }
        .variants-row{ display:flex; gap:8px; align-items:center }
        .variant-input{ flex:1 1 auto; min-width:0; padding:8px 10px; border-radius:6px; background:#ffffff; border:0; height:36px }
        .btn-ghost{ padding:8px 12px; border-radius:6px; background:#0084ff;color:#fff;border:0; height:36px }
        .chips{ margin-top:10px; display:flex; gap:8px; flex-wrap:wrap }
        .chip{ background:#f0f0f0; padding:6px 8px; border-radius:6px; display:inline-flex; align-items:center; gap:8px; font-size:13px; height:34px }
        .chip .x{ background:#ff4d4f;color:#fff;border-radius:4px;width:20px;height:20px;display:inline-flex;align-items:center;justify-content:center;font-weight:700;cursor:pointer;font-size:12px }
        .image-box{ background:#f2f2f2; height:160px; border-radius:8px; display:flex; align-items:center; justify-content:center; margin-top:8px; overflow:hidden }
        .image-box svg{ width:92px; height:92px; opacity:0.7 }
        .image-box img{ max-height:100%; max-width:100%; display:block }
        .btn-submit{ background:#005be6; color:#fff; padding:12px; border-radius:6px; border:0; width:100%; font-weight:800; font-size:15px }
        .product-create-wrap a{ display:inline-block; margin-bottom:10px; color:#222 }
    </style>

@endsection
