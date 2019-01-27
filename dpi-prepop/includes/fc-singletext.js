const singleText = `
    <div class='w-1 icons-list'>
        <div>
            <span class='super'>Icon: </span>
            <span ng-click='element.showIcons = !element.showIcons'>
                <i class='{{element.elementDefaults.selectedIcon}}'></i>
            </span>
            <div class='hide-checkbox' ng-show='element.showIcons'>
                <label ng-repeat='icon in listIcons'>
                    <input type='radio' name='{{element.elementDefaults.identifier}}_icon' update-label ng-model='element.elementDefaults.selectedIcon' value='{{icon.Value}}'/>
                    <i class='{{icon.Value}}'></i>
                </label>
            </div>
        </div>
    </div>
    <label class='w-3'>
        <span>Validation</span>
        <select ng-model='element.elementDefaults.Validation.allowed'>
            <option value=''>None</option>
            <option value='alphabets'>Only Alphabets</option>
            <option value='numbers'>Only Numbers</option>
            <option value='alphanumeric'>Only Alphabets & Numbers</option>
            <option value='url'>URL</option>
            <option value='regexp'>RegEx</option>
        </select>
    </label>
    <label ng-slide-toggle='element.elementDefaults.Validation.allowed=="regexp"' class='w-3'>
        <span>RegEx</span>
        <input type='text' ng-model='element.elementDefaults.Validation.regexp'>
        <i data-html='true' tooltip data-placement='top' data-toggle='tooltip' title='<strong>Common RegExp:</strong><br><strong>/^[a-z0-9_-]{6,18}$/</strong>: allow only alphabets, numbers, underscore and hyphen, and between 6 to 18 characters.<br><strong>/^[a-z0-9-]+$/</strong>: allow only alphabets, numbers and hyphens.<br><strong>/^[a-zA-Z]*$/</strong>: alphabets only, lower or upper case<br><strong>/^[0-9]*$/</strong>: digits only' class='icon-help'></i></label>
    <label class='w2-1'>
        <span>Min Chars</span>
        <input type='text' ng-model='element.elementDefaults.Validation.minChar'>
    </label>
    <label class='w2-1'>
        <span>Max Chars</span>
        <input type='text' ng-model='element.elementDefaults.Validation.maxChar'>
    </label>
    <label class='w-3'>
        <input type='checkbox' ng-model='element.elementDefaults.Validation.spaces'> 
        Allow Spaces
    </label>
    <label class='w-3'>
        <input type='checkbox' ng-model='element.elementDefaults.required'>
        Required Field
    </label>
`;

export default singleText;