const prePopField = `
    <div ng-controller="DpiPrePopController" class="oneLineText-cover field-cover">
        <span class="sub-label-{{element.elementDefaults.has_sub_label}}">
            <span compile="element.elementDefaults.main_label" class="main-label"></span>
            <span class="sub-label" compile="element.elementDefaults.sub_label"></span>
        </span>
        <div>
            <span class="error"></span>
            <input data-dpiprepop={{element.elementDefaults.prePopType}} type="text" placeholder="{{element.elementDefaults.main_label_placeholder}}" data-field-id="{{element.elementDefaults.identifier}}" name="{{element.elementDefaults.identifier}}[]" data-min-char="{{element.elementDefaults.Validation.minChar}}"
                data-max-char="{{element.elementDefaults.Validation.maxChar}}" data-val-type="{{element.elementDefaults.Validation.allowed}}" data-regexp="{{element.elementDefaults.Validation.regexp}}" data-is-required="{{element.elementDefaults.required}}" data-allow-spaces="{{element.elementDefaults.Validation.spaces}}"
                class="validation-lenient" data-placement="right" data-trigger="focus" data-html="true">
            <script type="text/javascript">
                if (!document.body.classList.contains('wp-admin')) {
                    if (!window.hasOwnProperty('prePopQueue')) {window.prePopQueue = [];}
                    window.prePopQueue.push(document.currentScript.previousElementSibling);
                }
            </script>
            <i class="{{element.elementDefaults.selectedIcon}}"></i>
        </div>
    </div>
`;

export default prePopField;