<template>
  <div>
    <b-sidebar id="sidebar-backdrop" title="" >
        <template #default="{hide}">
          <b-link @click="closeNav"><i class="btn fa fa-close fa-times"/></b-link>
              <b-navbar-brand href="#">    
                <img alt="alkatech logo" src="./../../../assets/alkatech.png">
              </b-navbar-brand>
              
            <div class="px-3 py-2">
              <!-- <b-form-group label="Backdrop variant" label-for="">
                <b-form-select id="backdrop-variant" v-model="variant" :options="variants"></b-form-select>
              </b-form-group> -->
                <nav class="mb-3 s-sidenav-text">
                  <hr>
                  <b-nav vertical>
                 
                    
                    <b-nav-item to="link1" @click="hide"><i class="fa fa-address-card" /> &nbsp; &nbsp; Link1 </b-nav-item>
                    <b-nav-item to="link2" @click="hide"><i class="fa fa-address-card" /> &nbsp; &nbsp; Link2 </b-nav-item>
                    <b-nav-item to="link3" @click="hide"><i class="fa fa-address-card" /> &nbsp; &nbsp; Link3 </b-nav-item>

                  </b-nav>
                </nav>
              
            </div>
        </template >
    </b-sidebar> 
  </div>
</template>

<script>

  export default {
    name:'Sidebar',
    data() {
      return {
        variant: 'dark',
        variants: [
          'transparent',
          'white',
          'light',
          'dark',
          'primary',
          'secondary',
          'success',
          'danger',
          'warning',
          'info',
        ]
      }
    },
    methods:{
  closeNav() {
  document.getElementById("sidebar-backdrop").setAttribute("style", "width:0px; transition: .5s;")
  // document.getElementById("app").classList.add("main-app-push-right");
  document.getElementById("app").setAttribute("style", "margin-left:0px; transition: .5s;")
}
}
  }

  

</script>
<style >
.s-sidenav-text{
  text-align: left;
}

  .s-fix-bottom-pposition{
    position: fixed;
    bottom:0;
    left:0;
  }
 .close{
   display: none !important;
 }
 .fa-close{  position: absolute;
    top: 6px;
    right: 6px;
    font-size: 20px;
    /* border: 2px solid blue; */
    padding: 6px;
    height: 32px;
    background: black;
    width: 32px;
    border-radius: 100%;
    box-shadow: -1px 1px 8px 0px red;
}
</style>