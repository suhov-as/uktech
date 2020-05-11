<div class="flex-group">
    <div class="input-holder first_name-field" style="margin-right: 1px;">
        <input type="text" name="first_name" placeholder="Name"/>
    </div>
    <div class="input-holder last_name-field" style="margin-right: 1px;">
        <input type="text" name="last_name" placeholder="Last name"/>
    </div>
    <div class="input-holder phone-field" style="margin-right: 1px;">
        <input type="text" name="phone" placeholder="Phone"/>
    </div>
    <div class="input-holder mail-field" style="margin-right: 1px;">
        <input type="email" name="email" placeholder="Email"/>
    </div>

    <input type="hidden" name="current_url" value="{{ \URL::full() }}"/>
    <input type="hidden" name="type" value="subscription_form"/>
    <input type="submit" class="button" value="{{ $send }}"/>
</div>
