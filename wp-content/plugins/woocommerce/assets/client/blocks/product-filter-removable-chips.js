(()=>{var e,o,t,r={6143:(e,o,t)=>{"use strict";t.r(o);const r=window.wc.wcSettings;var c=t(1609),l=t(5573);const i=(0,c.createElement)(l.SVG,{width:"24",height:"24",viewBox:"0 0 24 24",fill:"none",xmlns:"http://www.w3.org/2000/svg"},(0,c.createElement)(l.Path,{fillRule:"evenodd",clipRule:"evenodd",d:"M6 10C7.10457 10 8 9.10457 8 8C8 6.89543 7.10457 6 6 6C4.89543 6 4 6.89543 4 8C4 9.10457 4.89543 10 6 10ZM20 8.75H11.1111V7.25L20 7.25V8.75ZM20 15.75L11.1111 15.75V14.25L20 14.25V15.75ZM8 15C8 16.1046 7.10457 17 6 17C4.89543 17 4 16.1046 4 15C4 13.8954 4.89543 13 6 13C7.10457 13 8 13.8954 8 15Z",fill:"currentColor"})),n=window.wp.blocks,s=JSON.parse('{"$schema":"https://schemas.wp.org/trunk/block.json","name":"woocommerce/product-filter-removable-chips","version":"1.0.0","title":"Chips","description":"Display removable active filters as chips.","category":"woocommerce","keywords":["WooCommerce"],"textdomain":"woocommerce","apiVersion":3,"ancestor":["woocommerce/product-filter-active"],"supports":{"layout":{"allowSwitching":false,"allowInheriting":false,"allowJustification":false,"allowVerticalAlignment":false,"default":{"type":"flex"}}},"usesContext":["queryId","filterData"],"attributes":{"chipText":{"type":"string"},"customChipText":{"type":"string"},"chipBackground":{"type":"string"},"customChipBackground":{"type":"string"},"chipBorder":{"type":"string"},"customChipBorder":{"type":"string"}}}');var a=t(7723),p=t(851),u=t(8946),d=t(5202),m=t(7104),h=t(8098);const b=window.wc.blocksComponents,w=window.wp.components,f=window.wp.blockEditor;function v(e,o){return e?`var(--wp--preset--color--${e})`:o||""}function g(e){const{chipText:o,chipBackground:t,chipBorder:r,customChipText:c,customChipBackground:l,customChipBorder:i}=e,n={"--wc-product-filter-removable-chips-text":v(o,c),"--wc-product-filter-removable-chips-background":v(t,l),"--wc-product-filter-removable-chips-border":v(r,i)};return Object.keys(n).reduce(((e,o)=>(n[o]&&(e[o]=n[o]),e)),{})}function C(e){const{chipText:o,chipBackground:t,chipBorder:r,customChipText:c,customChipBackground:l,customChipBorder:i}=e;return{"has-chip-text-color":o||c,"has-chip-background-color":t||l,"has-chip-border-color":r||i}}const k=(0,f.withColors)({chipText:"chip-text",chipBorder:"chip-border",chipBackground:"chip-background"})((e=>{const o=(0,f.__experimentalUseMultipleOriginColorsAndGradients)(),{name:t,context:r,clientId:l,attributes:i,setAttributes:s,chipText:v,setChipText:k,chipBackground:y,setChipBackground:B,chipBorder:_,setChipBorder:x}=e,{customChipText:O,customChipBackground:E,customChipBorder:T,layout:j}=i,{filterData:P}=r,{items:S}=P,A=(0,n.getBlockSupport)(t,"layout"),M=null==A?void 0:A.default,V=j||M||{},N=(0,f.useBlockProps)({className:(0,p.A)("wc-block-product-filter-removable-chips",{...C(i)}),style:g(i)}),I=(0,f.useInnerBlocksProps)(N,{});return(0,c.createElement)("div",{...I},(0,c.createElement)(f.BlockControls,null,(0,c.createElement)(w.ToolbarGroup,null,(0,c.createElement)(w.ToolbarButton,{icon:u.A,label:(0,a.__)("Horizontal","woocommerce"),onClick:()=>s({layout:{...V,orientation:"horizontal"}}),isPressed:"horizontal"===V.orientation||!V.orientation}),(0,c.createElement)(w.ToolbarButton,{icon:d.A,label:(0,a.__)("Vertical","woocommerce"),onClick:()=>s({layout:{...V,orientation:"vertical"}}),isPressed:"vertical"===V.orientation}))),(0,c.createElement)("ul",{className:"wc-block-product-filter-removable-chips__items"},null==S?void 0:S.map(((e,o)=>{return(0,c.createElement)("li",{key:o,className:"wc-block-product-filter-removable-chips__item"},(0,c.createElement)("span",{className:"wc-block-product-filter-removable-chips__label"},e.type+": "+e.label),(0,c.createElement)("button",{className:"wc-block-product-filter-removable-chips__remove"},(0,c.createElement)(m.A,{className:"wc-block-product-filter-removable-chips__remove-icon",icon:h.A,size:25}),(0,c.createElement)(b.Label,{screenReaderLabel:(t=e.type+": "+e.label,(0,a.sprintf)(/* translators: %s attribute value used in the filter. For example: yellow, green, small, large. */ /* translators: %s attribute value used in the filter. For example: yellow, green, small, large. */
(0,a.__)("Remove %s filter","woocommerce"),t))})));var t}))),(0,c.createElement)(f.InspectorControls,{group:"color"},o.hasColorsOrGradients&&(0,c.createElement)(f.__experimentalColorGradientSettingsDropdown,{__experimentalIsRenderedInSidebar:!0,settings:[{label:(0,a.__)("Chip Text","woocommerce"),colorValue:v.color||O,onColorChange:e=>{k(e),s({customChipText:e})},resetAllFilter:()=>{k(""),s({customChipText:""})}},{label:(0,a.__)("Chip Border","woocommerce"),colorValue:_.color||T,onColorChange:e=>{x(e),s({customChipBorder:e})},resetAllFilter:()=>{x(""),s({customChipBorder:""})}},{label:(0,a.__)("Chip Background","woocommerce"),colorValue:y.color||E,onColorChange:e=>{B(e),s({customChipBackground:e})},resetAllFilter:()=>{B(""),s({customChipBackground:""})}}],panelId:l,...o})))}));t(7145),(()=>{const{experimentalBlocksEnabled:e}=(0,r.getSetting)("wcBlocksConfig",{experimentalBlocksEnabled:!1});return e})()&&(0,n.registerBlockType)(s,{edit:k,icon:i,save:({attributes:e,style:o})=>{const t=f.useBlockProps.save({className:(0,p.A)("wc-block-product-filter-removable-chips",e.className,C(e)),style:{...o,...g(e)}});return(0,c.createElement)("div",{...t})}})},7145:()=>{},1609:e=>{"use strict";e.exports=window.React},6087:e=>{"use strict";e.exports=window.wp.element},7723:e=>{"use strict";e.exports=window.wp.i18n},5573:e=>{"use strict";e.exports=window.wp.primitives}},c={};function l(e){var o=c[e];if(void 0!==o)return o.exports;var t=c[e]={exports:{}};return r[e].call(t.exports,t,t.exports,l),t.exports}l.m=r,e=[],l.O=(o,t,r,c)=>{if(!t){var i=1/0;for(p=0;p<e.length;p++){for(var[t,r,c]=e[p],n=!0,s=0;s<t.length;s++)(!1&c||i>=c)&&Object.keys(l.O).every((e=>l.O[e](t[s])))?t.splice(s--,1):(n=!1,c<i&&(i=c));if(n){e.splice(p--,1);var a=r();void 0!==a&&(o=a)}}return o}c=c||0;for(var p=e.length;p>0&&e[p-1][2]>c;p--)e[p]=e[p-1];e[p]=[t,r,c]},l.n=e=>{var o=e&&e.__esModule?()=>e.default:()=>e;return l.d(o,{a:o}),o},t=Object.getPrototypeOf?e=>Object.getPrototypeOf(e):e=>e.__proto__,l.t=function(e,r){if(1&r&&(e=this(e)),8&r)return e;if("object"==typeof e&&e){if(4&r&&e.__esModule)return e;if(16&r&&"function"==typeof e.then)return e}var c=Object.create(null);l.r(c);var i={};o=o||[null,t({}),t([]),t(t)];for(var n=2&r&&e;"object"==typeof n&&!~o.indexOf(n);n=t(n))Object.getOwnPropertyNames(n).forEach((o=>i[o]=()=>e[o]));return i.default=()=>e,l.d(c,i),c},l.d=(e,o)=>{for(var t in o)l.o(o,t)&&!l.o(e,t)&&Object.defineProperty(e,t,{enumerable:!0,get:o[t]})},l.o=(e,o)=>Object.prototype.hasOwnProperty.call(e,o),l.r=e=>{"undefined"!=typeof Symbol&&Symbol.toStringTag&&Object.defineProperty(e,Symbol.toStringTag,{value:"Module"}),Object.defineProperty(e,"__esModule",{value:!0})},l.j=6609,(()=>{var e={6609:0};l.O.j=o=>0===e[o];var o=(o,t)=>{var r,c,[i,n,s]=t,a=0;if(i.some((o=>0!==e[o]))){for(r in n)l.o(n,r)&&(l.m[r]=n[r]);if(s)var p=s(l)}for(o&&o(t);a<i.length;a++)c=i[a],l.o(e,c)&&e[c]&&e[c][0](),e[c]=0;return l.O(p)},t=self.webpackChunkwebpackWcBlocksMainJsonp=self.webpackChunkwebpackWcBlocksMainJsonp||[];t.forEach(o.bind(null,0)),t.push=o.bind(null,t.push.bind(t))})();var i=l.O(void 0,[94],(()=>l(6143)));i=l.O(i),((this.wc=this.wc||{}).blocks=this.wc.blocks||{})["product-filter-removable-chips"]=i})();