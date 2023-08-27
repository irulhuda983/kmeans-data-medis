import{N as H,E as C,F as m,I as L,H as S,o as h,c as g,a as s,z as v,n as $,t as k}from"./app-28aa7058.js";function j(e,t,...o){if(e in t){let n=t[e];return typeof n=="function"?n(...o):n}let r=new Error(`Tried to handle "${e}" but there is no handler defined. Only defined handlers are: ${Object.keys(t).map(n=>`"${n}"`).join(", ")}.`);throw Error.captureStackTrace&&Error.captureStackTrace(r,j),r}var D=(e=>(e[e.None=0]="None",e[e.RenderStrategy=1]="RenderStrategy",e[e.Static=2]="Static",e))(D||{}),P=(e=>(e[e.Unmount=0]="Unmount",e[e.Hidden=1]="Hidden",e))(P||{});function K({visible:e=!0,features:t=0,ourProps:o,theirProps:r,...n}){var a;let i=_(r,o),u=Object.assign(n,{props:i});if(e||t&2&&i.static)return x(u);if(t&1){let d=(a=i.unmount)==null||a?0:1;return j(d,{0(){return null},1(){return x({...n,props:{...i,hidden:!0,style:{display:"none"}}})}})}return x(u)}function x({props:e,attrs:t,slots:o,slot:r,name:n}){var a,i;let{as:u,...d}=T(e,["unmount","static"]),c=(a=o.default)==null?void 0:a.call(o,r),A={};if(r){let f=!1,w=[];for(let[b,p]of Object.entries(r))typeof p=="boolean"&&(f=!0),p===!0&&w.push(b);f&&(A["data-headlessui-state"]=w.join(" "))}if(u==="template"){if(c=O(c??[]),Object.keys(d).length>0||Object.keys(t).length>0){let[f,...w]=c??[];if(!N(f)||w.length>0)throw new Error(['Passing props on "template"!',"",`The current component <${n} /> is rendering a "template".`,"However we need to passthrough the following props:",Object.keys(d).concat(Object.keys(t)).map(l=>l.trim()).filter((l,y,B)=>B.indexOf(l)===y).sort((l,y)=>l.localeCompare(y)).map(l=>`  - ${l}`).join(`
`),"","You can apply a few solutions:",['Add an `as="..."` prop, to ensure that we render an actual element instead of a "template".',"Render a single element as the child so that we can forward the props onto that element."].map(l=>`  - ${l}`).join(`
`)].join(`
`));let b=_((i=f.props)!=null?i:{},d),p=H(f,b);for(let l in b)l.startsWith("on")&&(p.props||(p.props={}),p.props[l]=b[l]);return p}return Array.isArray(c)&&c.length===1?c[0]:c}return C(u,Object.assign({},d,A),{default:()=>c})}function O(e){return e.flatMap(t=>t.type===m?O(t.children):[t])}function _(...e){if(e.length===0)return{};if(e.length===1)return e[0];let t={},o={};for(let r of e)for(let n in r)n.startsWith("on")&&typeof r[n]=="function"?(o[n]!=null||(o[n]=[]),o[n].push(r[n])):t[n]=r[n];if(t.disabled||t["aria-disabled"])return Object.assign(t,Object.fromEntries(Object.keys(o).map(r=>[r,void 0])));for(let r in o)Object.assign(t,{[r](n,...a){let i=o[r];for(let u of i){if(n instanceof Event&&n.defaultPrevented)return;u(n,...a)}}});return t}function T(e,t=[]){let o=Object.assign({},e);for(let r of t)r in o&&delete o[r];return o}function N(e){return e==null?!1:typeof e.type=="string"||typeof e.type=="object"||typeof e.type=="function"}let U=0;function M(){return++U}function Q(){return M()}var R=(e=>(e.Space=" ",e.Enter="Enter",e.Escape="Escape",e.Backspace="Backspace",e.Delete="Delete",e.ArrowLeft="ArrowLeft",e.ArrowUp="ArrowUp",e.ArrowRight="ArrowRight",e.ArrowDown="ArrowDown",e.Home="Home",e.End="End",e.PageUp="PageUp",e.PageDown="PageDown",e.Tab="Tab",e))(R||{});function X(e){var t;return e==null||e.value==null?null:(t=e.value.$el)!=null?t:e.value}let E=Symbol("Context");var z=(e=>(e[e.Open=1]="Open",e[e.Closed=2]="Closed",e[e.Closing=4]="Closing",e[e.Opening=8]="Opening",e))(z||{});function Z(){return F()!==null}function F(){return L(E,null)}function ee(e){S(E,e)}const V={class:"w-full text-sm text-left bg-[#2F2B43]"},W={class:"text-xs text-gray-400 bg-[#3B3955] uppercase border-b border-[#3A3650]"},I={class:"bg-[#3A3650] text-[#3A3650] rounded"},Y=s("th",{scope:"col",class:"px-4 py-3"},[s("div",{class:"sr-only"},"Aksi")],-1),q={class:"bg-[#3A3650] text-[#3A3650] rounded"},G=s("td",{class:"px-4 py-3 text-right"},[s("div",{class:"w-full flex justify-end space-x-2"},[s("a",{href:"#",class:"block bg-[#3A3650] text-[#3A3650] hover:text-indigo-600 rounded"},[s("svg",{xmlns:"http://www.w3.org/2000/svg",fill:"none",viewBox:"0 0 24 24","stroke-width":"1.8",stroke:"currentColor",class:"w-5 h-5"},[s("path",{"stroke-linecap":"round","stroke-linejoin":"round",d:"M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10"})])]),s("a",{href:"#",class:"block bg-[#3A3650] text-[#3A3650] hover:text-indigo-600 rounded"},[s("svg",{xmlns:"http://www.w3.org/2000/svg",fill:"none",viewBox:"0 0 24 24","stroke-width":"1.8",stroke:"currentColor",class:"w-5 h-5"},[s("path",{"stroke-linecap":"round","stroke-linejoin":"round",d:"M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10"})])])])],-1),te={__name:"LoadingTable",props:["fields"],setup(e){const t=e;return(o,r)=>(h(),g("table",V,[s("thead",W,[s("tr",null,[(h(!0),g(m,null,v(t.fields,(n,a)=>(h(),g("th",{key:a,scope:"col",class:$(["px-4 py-3",a==0?"w-[10px]":""])},[s("span",I,k(n),1)],2))),128)),Y])]),s("tbody",null,[(h(),g(m,null,v(5,n=>s("tr",{key:n,class:"text-sm font-semibold cursor-pointer border-b bg-[#2F2B43] border-[#3A3650] text-[#9D9AB7]"},[(h(!0),g(m,null,v(t.fields,(a,i)=>(h(),g("td",{key:i,class:"px-4 py-3 whitespace-nowrap"},[s("span",q,k(a),1)]))),128)),G])),64))])]))}};export{Z as C,K as H,D as N,P as S,T,te as _,R as a,ee as c,z as l,X as o,F as p,Q as t,j as u};
