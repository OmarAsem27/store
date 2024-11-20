<div class="form-group">
    <x-form.input name="name" class="form-control" label="Role Name" :value="$role->name" />
</div>

<fieldset>
    <legend>{{ __('Abilities') }}</legend>
    @foreach (app('abilities') as $ability_key => $ability_name)
        <div class="row mb-2">
            <div class="col-md-6">
                {{ is_callable($ability_name) ? $ability_name() : $ability_name }}
            </div>
            <div class="col-md-2">
                <input type="radio" name="abilities[{{ $ability_key }}]" value="allow" @checked(($role_abilities[$ability_key] ?? '') == 'allow')>
                Allow
            </div>
            <div class="col-md-2">
                <input type="radio" name="abilities[{{ $ability_key }}]" value="deny" @checked(($role_abilities[$ability_key] ?? '') == 'deny')>
                Deny
            </div>
            <div class="col-md-2">
                <input type="radio" name="abilities[{{ $ability_key }}]" value="inherit"
                    @checked(($role_abilities[$ability_key] ?? '') == 'inherit')>
                Inherit
            </div>
        </div>
    @endforeach
</fieldset>

<div class="form-group">
    <button type="submit" class="btn btn-primary">{{ $button_label ?? 'Save' }}</button>
</div>
