(()=>{"use strict";var e,t={847:()=>{const e=window.wp.blocks,t=window.React,r=window.wp.i18n,o=window.wp.blockEditor,n=window.wp.components,s=JSON.parse('{"u2":"create-block/beastfeedbacks"}');(0,e.registerBlockType)(s.u2,{edit:function({attributes:e,className:s,setAttributes:a}){return(0,t.createElement)("div",{...(0,o.useBlockProps)()},(0,t.createElement)(n.Placeholder,{label:(0,r.__)("Gutenpride Block","gutenpride"),instructions:(0,r.__)("Add your message","gutenpride")},(0,t.createElement)(n.TextControl,{value:e.content,onChange:e=>a({message:e})})))},save:function({attributes:e}){const r=o.useBlockProps.save();return(0,t.createElement)("div",{...r},e.message)}})}},r={};function o(e){var n=r[e];if(void 0!==n)return n.exports;var s=r[e]={exports:{}};return t[e](s,s.exports,o),s.exports}o.m=t,e=[],o.O=(t,r,n,s)=>{if(!r){var a=1/0;for(u=0;u<e.length;u++){for(var[r,n,s]=e[u],i=!0,c=0;c<r.length;c++)(!1&s||a>=s)&&Object.keys(o.O).every((e=>o.O[e](r[c])))?r.splice(c--,1):(i=!1,s<a&&(a=s));if(i){e.splice(u--,1);var l=n();void 0!==l&&(t=l)}}return t}s=s||0;for(var u=e.length;u>0&&e[u-1][2]>s;u--)e[u]=e[u-1];e[u]=[r,n,s]},o.o=(e,t)=>Object.prototype.hasOwnProperty.call(e,t),(()=>{var e={826:0,431:0};o.O.j=t=>0===e[t];var t=(t,r)=>{var n,s,[a,i,c]=r,l=0;if(a.some((t=>0!==e[t]))){for(n in i)o.o(i,n)&&(o.m[n]=i[n]);if(c)var u=c(o)}for(t&&t(r);l<a.length;l++)s=a[l],o.o(e,s)&&e[s]&&e[s][0](),e[s]=0;return o.O(u)},r=globalThis.webpackChunkbeastfeedbacks=globalThis.webpackChunkbeastfeedbacks||[];r.forEach(t.bind(null,0)),r.push=t.bind(null,r.push.bind(r))})();var n=o.O(void 0,[431],(()=>o(847)));n=o.O(n)})();