import{d as M,r as g,o as D,f as z,a as L,c as R,e as r,b as l,g as o,u as a,h as O,E as i,j as A,k as G,l as H,m as u,t as _,n as T,p as K,q as Q,s as X,v as Y,x as Z,y as ee,z as te}from"./index-2d2b0b3d.js";/* empty css                  *//* empty css                   *//* empty css                *//* empty css                 *//* empty css               */import"./el-form-item-4ed993c7.js";/* empty css                        */import{o as V,c as v}from"./loading-bf393b7e.js";/* empty css                       */const le=r("h1",null,"員工管理",-1),ae={style:{display:"flex","justify-content":"end","margin-top":"10px"}},oe={style:{margin:"1rem 0 0 2rem"}},ne={class:"userInfo"},se=r("span",{class:"title"},"帳號:",-1),re={class:"userInfo"},de=r("span",{class:"title"},"姓名:",-1),ue={class:"userInfo"},ie=r("span",{class:"title"},"電話:",-1),me={class:"userInfo"},pe=r("span",{class:"title"},"地址:",-1),fe={class:"userInfo"},ce=r("span",{class:"title"},"職稱:",-1),ge={class:"userInfo"},ye=r("span",{class:"title"},"底薪:",-1),_e=r("p",{style:{color:"red"}},"*預設密碼為電話號碼!",-1),he={class:"dialog-footer"},be={class:"dialog-footer"},je=M({__name:"personalManage",setup(ve){const h=g([]),b=g(!1),y=g(!1),w=g(null),E=g(null),U=g("90%"),m=g({username:"",name:"",telephone:"",address:"",type:"",basicSalary:null}),d=g({id:"",username:"",name:"",telephone:"",address:"",type:"",basicSalary:null}),F=n=>{n&&n.validate(e=>{if(e)T.confirm("確定要新增員工資料嗎?","Warning",{confirmButtonText:"確認",cancelButtonText:"取消",type:"warning"}).then(()=>{V("資料傳輸中..."),fetch("/api/manageUser",{method:"POST",headers:{"Content-Type":"application/json"},body:JSON.stringify({option:"add",data:m.value})}).then(s=>s.json()).then(s=>{s.code==200?(i.success("新增成功"),h.value.push(s.data),b.value=!1):s.code==400?i.error("用戶已存在"):i.error("新增失敗")}).catch(()=>{i.error("新增失敗")}).finally(()=>{n.resetFields(),v()})}).catch(()=>{});else return!1})},I=n=>{d.value=JSON.parse(JSON.stringify(h.value.find(e=>e.id==n))),y.value=!0},N=n=>{T.confirm("確定要刪除員工資料嗎?","Warning",{confirmButtonText:"確認",cancelButtonText:"取消",type:"warning"}).then(()=>{V("資料傳輸中..."),fetch("/api/manageUser",{method:"POST",headers:{"Content-Type":"application/json"},body:JSON.stringify({option:"delete",userId:n})}).then(e=>e.json()).then(e=>{e.code==200?(i.success("刪除成功"),h.value=h.value.filter(s=>s.id!=n)):i.error("刪除失敗")}).catch(()=>{i.error("刪除失敗")}).finally(()=>{v()})}).catch(()=>{})},W=()=>{T.confirm("確定要重置員工密碼嗎?","Warning",{confirmButtonText:"確認",cancelButtonText:"取消",type:"warning"}).then(()=>{V("資料傳輸中..."),fetch("/api/manageUser",{method:"POST",headers:{"Content-Type":"application/json"},body:JSON.stringify({option:"resetPassword",userId:d.value.id})}).then(n=>n.json()).then(n=>{n.code==200?i.success("重置成功"):i.error("重置失敗")}).catch(()=>{i.error("重置失敗")}).finally(()=>{y.value=!1,v()})}).catch(()=>{})},$=n=>{n&&n.validate(e=>{if(e)T.confirm("確定要修改員工資料嗎?","Warning",{confirmButtonText:"確認",cancelButtonText:"取消",type:"warning"}).then(()=>{V("資料傳輸中..."),fetch("/api/manageUser",{method:"POST",headers:{"Content-Type":"application/json"},body:JSON.stringify({option:"edit",data:d.value})}).then(s=>s.json()).then(s=>{s.code=="200"?(i.success("修改成功"),C()):(i.error("修改失敗"),v())}).catch(()=>{i.error("修改失敗"),v()}).finally(()=>{y.value=!1})}).catch(()=>{});else return!1})},C=()=>{V("資料載入中..."),fetch("/api/getAllUserData",{headers:{"Content-Type":"application/json"}}).then(n=>n.json()).then(n=>{n.code===200?h.value=n.data:i.error("資料取得失敗")}).catch(()=>{i.error("資料取得失敗")}).finally(()=>{v()})};D(()=>{C(),U.value=window.innerWidth<768?"90%":"50%",window.addEventListener("resize",()=>{U.value=window.innerWidth<768?"90%":"50%"})});const x=z({username:[{required:!0,message:"請輸入帳號名稱",trigger:"change"},{min:6,max:20,message:"長度需在 6 到 20 個字元",trigger:"change"}],name:[{required:!0,message:"請輸入姓名",trigger:"change"}],telephone:[{required:!0,message:"請輸入電話號碼",trigger:"change"}],address:[{required:!0,message:"請輸入住址",trigger:"change"}],type:[{required:!0,message:"請選擇職稱",trigger:"change"}],basicSalary:[{required:!0,message:"請輸入基本薪資",trigger:"change"},{type:"number",message:"請輸入數字",trigger:"change"}]});return(n,e)=>{const s=A,S=K,q=Q,P=G,f=X,p=Y,c=Z,k=ee,B=te,j=H;return L(),R("div",null,[le,r("div",ae,[l(s,{type:"primary",onClick:e[0]||(e[0]=t=>b.value=!0)},{default:o(()=>[u("新增員工")]),_:1})]),l(P,{data:a(h),style:{width:"100%"},border:!0},{default:o(()=>[l(S,{type:"expand"},{default:o(t=>[r("div",oe,[r("p",ne,[se,u(" "+_(t.row.username),1)]),r("p",re,[de,u(" "+_(t.row.name),1)]),r("p",ue,[ie,u(" "+_(t.row.telephone),1)]),r("p",me,[pe,u(" "+_(t.row.address),1)]),r("p",fe,[ce,u(" "+_(t.row.type=="normal"?"員工":t.row.type=="manager"?"主管":"人事"),1)]),r("p",ge,[ye,u(" "+_(t.row.basicSalary),1)])])]),_:1}),l(S,{prop:"name",label:"性名"}),l(S,{prop:"type",label:"職稱"},{default:o(t=>[l(q,{type:t.row.type=="normal"?"":t.row.type=="manager"?"success":t.row.type=="accountant"?"warning":"danger",effect:"dark"},{default:o(()=>[u(_(t.row.type=="normal"?"員工":t.row.type=="manager"?"主管":t.row.type=="accountant"?"會計":"人事"),1)]),_:2},1032,["type"])]),_:1}),l(S,{prop:"id",label:"操作",width:"150"},{default:o(t=>[l(s,{type:"primary",size:"small",onClick:J=>I(t.row.id)},{default:o(()=>[u("修改")]),_:2},1032,["onClick"]),l(s,{type:"danger",size:"small",onClick:J=>N(t.row.id)},{default:o(()=>[u("刪除")]),_:2},1032,["onClick"])]),_:1})]),_:1},8,["data"]),l(j,{modelValue:a(b),"onUpdate:modelValue":e[10]||(e[10]=t=>O(b)?b.value=t:null),title:"新增員工",width:a(U)},{footer:o(()=>[r("span",he,[l(s,{onClick:e[7]||(e[7]=t=>(b.value=!1,a(w).resetFields()))},{default:o(()=>[u("取消")]),_:1}),l(s,{type:"warning",onClick:e[8]||(e[8]=t=>a(w).resetFields())},{default:o(()=>[u("重置")]),_:1}),l(s,{type:"primary",onClick:e[9]||(e[9]=t=>F(a(w)))},{default:o(()=>[u(" 新增 ")]),_:1})])]),default:o(()=>[l(B,{model:a(m),ref_key:"UserFormRef",ref:w,rules:a(x)},{default:o(()=>[_e,l(p,{label:"帳號",prop:"username"},{default:o(()=>[l(f,{modelValue:a(m).username,"onUpdate:modelValue":e[1]||(e[1]=t=>a(m).username=t),autocomplete:"off"},null,8,["modelValue"])]),_:1}),l(p,{label:"姓名",prop:"name"},{default:o(()=>[l(f,{modelValue:a(m).name,"onUpdate:modelValue":e[2]||(e[2]=t=>a(m).name=t),autocomplete:"off"},null,8,["modelValue"])]),_:1}),l(p,{label:"電話號碼",prop:"telephone"},{default:o(()=>[l(f,{modelValue:a(m).telephone,"onUpdate:modelValue":e[3]||(e[3]=t=>a(m).telephone=t),autocomplete:"off"},null,8,["modelValue"])]),_:1}),l(p,{label:"住址",prop:"address"},{default:o(()=>[l(f,{modelValue:a(m).address,"onUpdate:modelValue":e[4]||(e[4]=t=>a(m).address=t),autocomplete:"off"},null,8,["modelValue"])]),_:1}),l(p,{label:"職稱",prop:"type"},{default:o(()=>[l(k,{modelValue:a(m).type,"onUpdate:modelValue":e[5]||(e[5]=t=>a(m).type=t),placeholder:"職稱"},{default:o(()=>[l(c,{label:"員工",value:"normal"}),l(c,{label:"主管",value:"manager"}),l(c,{label:"人事",value:"personal"}),l(c,{label:"會計",value:"accountant"})]),_:1},8,["modelValue"])]),_:1}),l(p,{label:"底薪",prop:"basicSalary"},{default:o(()=>[l(f,{modelValue:a(m).basicSalary,"onUpdate:modelValue":e[6]||(e[6]=t=>a(m).basicSalary=t),modelModifiers:{number:!0},autocomplete:"off"},null,8,["modelValue"])]),_:1})]),_:1},8,["model","rules"])]),_:1},8,["modelValue","width"]),l(j,{modelValue:a(y),"onUpdate:modelValue":e[20]||(e[20]=t=>O(y)?y.value=t:null),title:"修改員工資訊",width:a(U)},{footer:o(()=>[r("span",be,[l(s,{type:"danger",onClick:e[17]||(e[17]=t=>W())},{default:o(()=>[u("重置密碼")]),_:1}),l(s,{onClick:e[18]||(e[18]=t=>(y.value=!1,a(E).resetFields()))},{default:o(()=>[u("取消")]),_:1}),l(s,{type:"primary",onClick:e[19]||(e[19]=t=>$(a(E)))},{default:o(()=>[u(" 修改 ")]),_:1})])]),default:o(()=>[l(B,{model:a(d),ref_key:"EditUserFormRef",ref:E,rules:a(x)},{default:o(()=>[l(p,{label:"帳號",prop:"username"},{default:o(()=>[l(f,{modelValue:a(d).username,"onUpdate:modelValue":e[11]||(e[11]=t=>a(d).username=t),autocomplete:"off"},null,8,["modelValue"])]),_:1}),l(p,{label:"姓名",prop:"name"},{default:o(()=>[l(f,{modelValue:a(d).name,"onUpdate:modelValue":e[12]||(e[12]=t=>a(d).name=t),autocomplete:"off"},null,8,["modelValue"])]),_:1}),l(p,{label:"電話號碼",prop:"telephone"},{default:o(()=>[l(f,{modelValue:a(d).telephone,"onUpdate:modelValue":e[13]||(e[13]=t=>a(d).telephone=t),autocomplete:"off"},null,8,["modelValue"])]),_:1}),l(p,{label:"住址",prop:"address"},{default:o(()=>[l(f,{modelValue:a(d).address,"onUpdate:modelValue":e[14]||(e[14]=t=>a(d).address=t),autocomplete:"off"},null,8,["modelValue"])]),_:1}),l(p,{label:"職稱",prop:"type"},{default:o(()=>[l(k,{modelValue:a(d).type,"onUpdate:modelValue":e[15]||(e[15]=t=>a(d).type=t),placeholder:"職稱"},{default:o(()=>[l(c,{label:"員工",value:"normal"}),l(c,{label:"主管",value:"manager"}),l(c,{label:"人事",value:"personnel"}),l(c,{label:"會計",value:"accountant"})]),_:1},8,["modelValue"])]),_:1}),l(p,{label:"底薪",prop:"basicSalary"},{default:o(()=>[l(f,{modelValue:a(d).basicSalary,"onUpdate:modelValue":e[16]||(e[16]=t=>a(d).basicSalary=t),modelModifiers:{number:!0},autocomplete:"off"},null,8,["modelValue"])]),_:1})]),_:1},8,["model","rules"])]),_:1},8,["modelValue","width"])])}}});export{je as default};