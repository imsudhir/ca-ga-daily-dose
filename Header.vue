<template>
 
    <b-navbar class="s-nav-bg" toggleable="lg" type="dark" variant="primary">
        <!-- <b-navbar-brand href="#">ALKATECH-CRM</b-navbar-brand> -->
        <b-navbar-toggle v-b-toggle.sidebar-backdrop target="nav-collapse"></b-navbar-toggle>
        <b-collapse id="nav-collapse" is-nav>
        <b-navbar-nav>
          <b-button  @click="openNav"   class="btn ripple"  > <i class="fas fa-bars" variant="primary"></i> </b-button>
        </b-navbar-nav>


        <!-- Right aligned nav items -->
        <b-navbar-nav class="ml-auto">
            <b-nav-item-dropdown text="Lang" right>
                <b-dropdown-item href="#">EN</b-dropdown-item>
                <b-dropdown-item href="#">ES</b-dropdown-item>
                <b-dropdown-item href="#">RU</b-dropdown-item>
                <b-dropdown-item href="#">FA</b-dropdown-item>
            </b-nav-item-dropdown>

            <b-nav-item-dropdown right>
            <!-- Using 'button-content' slot -->
            <template #button-content>
                <em><i class="fa fa-user" /></em>
            </template>
            <b-dropdown-item href="#">Profile</b-dropdown-item>
            <b-dropdown-item href="#">Sign Out</b-dropdown-item>
            </b-nav-item-dropdown>
        </b-navbar-nav>
        </b-collapse>
    </b-navbar>
</template>

<script>
export default {
name:'Sidebar',
methods:{
  openNav() {
  document.getElementById("sidebar-backdrop").setAttribute("style", "width:320px;transition: .5s;")
  // document.getElementById("app").classList.add("main-app-push-right");
  document.getElementById("app").setAttribute("style", "margin-left:320px;transition: .5s;")
}
}
}

// function openNav() {
//   document.getElementById("sidebar-backdrop").classList.add("open-sidenav");
//   document.getElementById("app").classList.add("main-app-push-right");
// }
// openNav();
// closeNav();
// function closeNav() {
//   document.getElementById("sidebar-backdrop").classList.add("close-sidenav");
//   document.getElementById("app").classList.add("main-app");
// }



</script>
<style>
 .close-sidenav{
    width: 0px !important;
  }
  .open-sidenav{
    width: 320px !important;
  }
  .main-app-push-right{
    margin-left: 320px !important;
  }
  .main-app{
    margin-left: 0px !important;
  }



.s-nav-bg{
        background-color: #330a75!important;
}
.ripple {
  position: relative;
  overflow: hidden;
  transform: translate3d(0, 0, 0);
}

.ripple:after {
  content: "";
  display: block;
  position: absolute;
  width: 100%;
  height: 100%;
  top: 0;
  left: 0;
  pointer-events: none;
  background-image: radial-gradient(circle, #fff 10%, transparent 10.01%);
  background-repeat: no-repeat;
  background-position: 50%;
  transform: scale(10, 10);
  opacity: 0;
  transition: transform .5s, opacity 1s;
}

.ripple:active:after {
  transform: scale(0, 0);
  opacity: .3;
  transition: 0s;
}

/* btn styles */
.btn {
  background-color: #3e3ebb;
  color: #fff;
  font-size: 1.3rem;
  padding: 6px 12px;
  box-sizing: border-box;
  cursor: pointer;
  display: inline-flex;
  align-items: center;
  justify-content: center;
  text-align: center;
  text-decoration: none;
  transition: 0.3s;
  border: 2px solid #3e3ebb;
  outline: none;
  white-space: nowrap;
  font-weight: 500;
  vertical-align: middle;
  margin: 0px;
  box-shadow: 0 0 2px -2px rgba(29, 39, 231, .1),
    0 0 3px 0 rgba(29, 39, 231, .1),
    0 0 5px 0 rgba(29, 39, 231, .1),
    0 2px 2px -4px rgba(29, 39, 231, .1),
    0 4px 8px 0 rgba(29, 39, 231, .1),
    0 2px 15px 0 rgba(29, 39, 231, .1)
}
.btn:hover {
  background-color: #131BB4;
  border-color: #131BB4;
  color: #fff;
}
  .button.btn.ripple.btn-secondary:focus{
    background: #1d27e7;
  }
</style>