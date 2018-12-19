<?php ?>
<form autocomplete="off" class="appForm clearfix" method="post" enctype="application/x-www-form-urlencoded">
    <fieldset>
        <legend><?= $text_legend ?></legend>
        <div class="input_wrapper n20 border">
            <label class="floated"><?= $text_label_FirstName ?></label>
            <input required type="text" name="FirstName" maxlength="10" value="">
        </div>
        <div class="input_wrapper n20 border padding">
            <label class="floated"><?= $text_label_LastName ?></label>
            <input required type="text" name="LastName" maxlength="10" value="">
        </div>
        <div class="input_wrapper n20 padding border">
            <label class="floated"><?= $text_label_Username ?></label>
            <input required type="text" name="Username" maxlength="30" value="">
        </div>
        <div class="input_wrapper n20 border padding">
            <label class="floated"><?= $text_label_Password ?></label>
            <input required type="password" name="Password" value="">
        </div>
        <div class="input_wrapper n20 padding">
            <label class="floated"><?= $text_label_CPassword ?></label>
            <input required type="password" name="CPassword" value="">
        </div>
        <div class="input_wrapper n30 border">
            <label class="floated"><?= $text_label_Email ?></label>
            <input required type="email" name="Email" maxlength="40" value="">
        </div>
        <div class="input_wrapper n30 border padding">
            <label class="floated"><?= $text_label_CEmail ?></label>
            <input required type="email" name="CEmail" maxlength="40" value="">
        </div>
        <div class="input_wrapper n20 padding border">
            <label class="floated"><?= $text_label_PhoneNumber ?></label>
            <input required type="text" name="PhoneNumber" value="">
        </div>
        <div class="input_wrapper_other padding n20 select">
            <select required name="GroupId">
                <option value=""><?= $text_user_GroupId ?></option>
                <?php if (false !== $groups): foreach ($groups as $group): ?>
                    <option value="<?= $group->GroupId ?>"><?= $group->GroupName ?></option>
                <?php endforeach;endif; ?>
            </select>
        </div>

        <input class="no_float" type="submit" name="submit" value="<?= $text_label_save ?>">
    </fieldset>
</form>