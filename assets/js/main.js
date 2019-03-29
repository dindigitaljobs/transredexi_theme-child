"use strict";(function($){"use strict";var SPMaskBehavior=function SPMaskBehavior(val){return val.replace(/\D/g,"").length===11?"(00) 00000-0000":"(00) 0000-00009"},spOptions={onKeyPress:function onKeyPress(val,e,field,options){field.mask(SPMaskBehavior.apply({},arguments),options)}};$('[type="tel"]').mask(SPMaskBehavior,spOptions)})(jQuery);
//# sourceMappingURL=main.js.map
