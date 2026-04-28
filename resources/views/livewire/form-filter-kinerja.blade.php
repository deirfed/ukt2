<div>
    <div class="form-group">
        <label class="form-label required">Seksi</label>
        <select wire:model.live='seksi_id' name="seksi_id" id="seksi_id" class="form-control" required>
            <option value="">- pilih seksi -</option>
            @foreach ($seksi as $item)
                <option value="{{ $item->id }}">{{ $item->name }}</option>
            @endforeach
        </select>
    </div>
    <div class="form-group">
        <label class="form-label optional">Pulau</label>
        <select wire:model.live="pulau_id" name="pulau_id" id="pulau_id" class="form-control"
            {{ is_null($seksi_id) ? 'disabled' : '' }}>
            <option value="">- pilih Pulau -</option>
            @foreach ($pulau as $item)
                <option value="{{ $item->id }}">{{ $item->name }}</option>
            @endforeach
        </select>
    </div>
    <div class="form-group">
        <label class="form-label {{ $user_required ? 'required' : 'optional' }}">Personel</label>
        <select wire:model.live="user_id" name="user_id" id="user_id" class="form-control"
            {{ is_null($seksi_id) ? 'disabled' : '' }} {{ $user_required ? 'required' : '' }}>
            <option value="">- pilih personel -</option>
            @foreach ($user as $item)
                <option value="{{ $item->id }}">{{ $item->name }}</option>
            @endforeach
        </select>
    </div>
    <div class="form-group">
        <label class="form-label {{ $kategori_required ? 'required' : 'optional' }}">Kegiatan</label>
        <select wire:model.live="kategori_id" name="kategori_id" id="kategori_id" class="form-control"
            {{ is_null($seksi_id) ? 'disabled' : '' }} {{ $kategori_required ? 'required' : '' }}>
            <option value="">- pilih kegiatan -</option>
            @foreach ($kategori as $item)
                <option value="{{ $item->id }}">{{ $item->name }}</option>
            @endforeach
        </select>
    </div>
</div>
