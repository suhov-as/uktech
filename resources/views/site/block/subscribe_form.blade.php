<div class="flex-group">
    <div class="input-holder email-field">
        <input type="text" name="first_name" placeholder="Name"/>
    </div>
    <div class="input-holder email-field">
        <input type="text" name="last_name" placeholder="Last name"/>
    </div>
    <div class="input-holder email-field">
        <input type="text" name="phone" placeholder="Phone"/>
    </div>
    <div class="input-holder email-field">
        <input type="email" name="email" placeholder="Email"/>
    </div>

    <input type="hidden" name="current_url" value="{{ \URL::full() }}"/>
    <input type="hidden" name="type" value="subscription_form"/>
    <input type="submit" class="button" value="{{ $send }}"/>
</div>
