import{o,c,a as s,s as l,t}from"./app-4b9da51d.js";const d={class:"box-border w-full flex flex-col lg:flex-row py-10"},i={class:"w-full lg:w-1/2 box-border bg-[#3B3955] rounded box-border p-6 lg:mr-5 mb-5 lg:mb-0 flex flex-col lg:flex-row"},a={class:"w-full lg:w-auto flex-none flex items-start justify-center mb-2 mr-5"},n={class:"w-56 h-56 mb-5 lg:mb-0 bg-gray-300 rounded-lg box-border overflow-hidden"},_=["src"],r={class:"w-full flex-1"},m={class:"w-full flex items-center text-sm mb-2"},u=s("div",{class:"w-32"},"Nama",-1),f=s("div",{class:"w-4"},":",-1),b={class:"w-full flex items-center text-sm mb-2"},x=s("div",{class:"w-32"},"Username",-1),w=s("div",{class:"w-4"},":",-1),h={class:"w-full flex items-center text-sm mb-2"},v=s("div",{class:"w-32"},"Email",-1),g=s("div",{class:"w-4"},":",-1),p={class:"w-full flex items-center text-sm mb-2"},B=s("div",{class:"w-32"},"Bergabung",-1),S=s("div",{class:"w-4"},":",-1),y={class:"text-xs"},E=s("div",null,[s("button",null,"edit")],-1),N=s("div",{class:"w-full lg:w-1/2 box-border bg-[#3B3955] rounded box-border p-4 mb-10 lg:mb-0"}," ubah password ",-1),j={__name:"Main",setup(U){const e=localStorage.getItem("USER")?JSON.parse(localStorage.getItem("USER")):null;return console.log(e),(k,I)=>(o(),c("div",d,[s("div",i,[s("div",a,[s("div",n,[s("img",{src:l(e).foto,alt:"",class:"w-full"},null,8,_)])]),s("div",r,[s("div",m,[u,f,s("div",null,t(l(e).nama),1)]),s("div",b,[x,w,s("div",null,t(l(e).username),1)]),s("div",h,[v,g,s("div",null,t(l(e).email),1)]),s("div",p,[B,S,s("div",y,t(l(e).created_at.split("T")[0]),1)]),E])]),N]))}};export{j as default};