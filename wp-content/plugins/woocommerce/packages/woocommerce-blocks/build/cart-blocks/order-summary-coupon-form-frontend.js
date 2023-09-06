(window.webpackWcBlocksJsonp=window.webpackWcBlocksJsonp||[]).push([[26],{272:function(e,o,t){"use strict";var n=t(13),c=t.n(n),a=t(0),s=t(62),r=t(5),p=t.n(r),l=t(143);t(273),o.a=e=>{let{className:o,showSpinner:t=!1,children:n,variant:r="contained",...i}=e;const u=p()("wc-block-components-button","wp-element-button",o,r,{"wc-block-components-button--loading":t});return Object(a.createElement)(s.a,c()({className:u},i),t&&Object(a.createElement)(l.a,null),Object(a.createElement)("span",{className:"wc-block-components-button__text"},n))}},273:function(e,o){},302:function(e,o,t){"use strict";t.d(o,"a",(function(){return l}));var n=t(1),c=t(6),a=t(3),s=t(22),r=t(11),p=t(42);const l=function(){let e=arguments.length>0&&void 0!==arguments[0]?arguments[0]:"";const{cartCoupons:o,cartIsLoading:t}=Object(p.a)(),{createErrorNotice:l}=Object(c.useDispatch)("core/notices"),{createNotice:i}=Object(c.useDispatch)("core/notices"),{setValidationErrors:u}=Object(c.useDispatch)(a.VALIDATION_STORE_KEY),{isApplyingCoupon:b,isRemovingCoupon:m}=Object(c.useSelect)(e=>{const o=e(a.CART_STORE_KEY);return{isApplyingCoupon:o.isApplyingCoupon(),isRemovingCoupon:o.isRemovingCoupon()}},[l,i]),{applyCoupon:d,removeCoupon:O}=Object(c.useDispatch)(a.CART_STORE_KEY),g=o=>d(o).then(()=>(Object(r.applyCheckoutFilter)({filterName:"showApplyCouponNotice",defaultValue:!0,arg:{couponCode:o,context:e}})&&i("info",Object(n.sprintf)(
/* translators: %s coupon code. */
Object(n.__)('Coupon code "%s" has been applied to your cart.',"woocommerce"),o),{id:"coupon-form",type:"snackbar",context:e}),Promise.resolve(!0))).catch(e=>(u({coupon:{message:Object(s.decodeEntities)(e.message),hidden:!1}}),Promise.resolve(!1))),_=o=>O(o).then(()=>(Object(r.applyCheckoutFilter)({filterName:"showRemoveCouponNotice",defaultValue:!0,arg:{couponCode:o,context:e}})&&i("info",Object(n.sprintf)(
/* translators: %s coupon code. */
Object(n.__)('Coupon code "%s" has been removed from your cart.',"woocommerce"),o),{id:"coupon-form",type:"snackbar",context:e}),Promise.resolve(!0))).catch(o=>(l(o.message,{id:"coupon-form",context:e}),Promise.resolve(!1)));return{appliedCoupons:o,isLoading:t,applyCoupon:g,removeCoupon:_,isApplyingCoupon:b,isRemovingCoupon:m}}},376:function(e,o){},439:function(e,o,t){"use strict";var n=t(0),c=t(1),a=t(272),s=t(144),r=t(10),p=t(11),l=t(6),i=t(3),u=t(5),b=t.n(u);t(376),o.a=Object(r.withInstanceId)(e=>{let{instanceId:o,isLoading:t=!1,onSubmit:r,displayCouponForm:u=!1}=e;const[m,d]=Object(n.useState)(""),[O,g]=Object(n.useState)(!u),_="wc-block-components-totals-coupon__input-"+o,j=b()("wc-block-components-totals-coupon__content",{"screen-reader-text":O}),{validationErrorId:w}=Object(l.useSelect)(e=>({validationErrorId:e(i.VALIDATION_STORE_KEY).getValidationErrorId(_)}));return Object(n.createElement)("div",{className:"wc-block-components-totals-coupon"},O?Object(n.createElement)("a",{role:"button",href:"#wc-block-components-totals-coupon__form",className:"wc-block-components-totals-coupon-link","aria-label":Object(c.__)("Add a coupon","woocommerce"),onClick:e=>{e.preventDefault(),g(!1)}},Object(c.__)("Add a coupon","woocommerce")):Object(n.createElement)(s.a,{screenReaderLabel:Object(c.__)("Applying coupon…","woocommerce"),isLoading:t,showSpinner:!1},Object(n.createElement)("div",{className:j},Object(n.createElement)("form",{className:"wc-block-components-totals-coupon__form",id:"wc-block-components-totals-coupon__form"},Object(n.createElement)(p.ValidatedTextInput,{id:_,errorId:"coupon",className:"wc-block-components-totals-coupon__input",label:Object(c.__)("Enter code","woocommerce"),value:m,ariaDescribedBy:w,onChange:e=>{d(e)},focusOnMount:!0,showError:!1}),Object(n.createElement)(a.a,{className:"wc-block-components-totals-coupon__button",disabled:t||!m,showSpinner:t,onClick:e=>{e.preventDefault(),void 0!==r?r(m).then(e=>{e&&(d(""),g(!0))}):(d(""),g(!0))},type:"submit"},Object(c.__)("Apply","woocommerce"))),Object(n.createElement)(p.ValidationInputError,{propertyName:"coupon",elementId:_}))))})},516:function(e,o,t){"use strict";t.r(o);var n=t(0),c=t(439),a=t(302),s=t(2),r=t(11);o.default=e=>{let{className:o}=e;const t=Object(s.getSetting)("couponsEnabled",!0),{applyCoupon:p,isApplyingCoupon:l}=Object(a.a)("wc/cart");return t?Object(n.createElement)(r.TotalsWrapper,{className:o},Object(n.createElement)(c.a,{onSubmit:p,isLoading:l})):null}}}]);