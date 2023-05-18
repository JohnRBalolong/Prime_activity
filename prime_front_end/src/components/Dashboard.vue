<template>
  <div>
    <div class="card relative z-5">
      <Menubar :model="items">
        <template #start>
          <img style="margin-left: 30px;" alt="logo" src="@/assets/mylogo.png" height="70" class="mr-2" />
        </template>
        <!-- <template #end>
          <InputText placeholder="Search" type="text" />
        </template> -->
      </Menubar>
    </div>

    <div>
      <dashcontent />
      
      <br>

      <favorites />
      
      <sidebar />
    </div>
  </div>
</template>


<script>
/* eslint-disable vue/multi-word-component-names */
// import Sidebar from 'primevue/sidebar';
// import Button from 'primevue/button';
import router from '../routes.js'
import favorites from '../components/favorites.vue'
import dashcontent from '../components/dashcontent.vue'
import sidebar from '../components/sidebar.vue'

// import InputText from 'primevue/inputtext';
import Menubar from 'primevue/menubar';
import { ref } from 'vue';

export default {
 name: 'Dashboard',
 components: {
  //  Sidebar,
  //  Button,
  // InputText,
   Menubar,
   dashcontent,
   favorites,
   sidebar,
 },
 setup() {

   // Define logout function
   function logout() {
      // Clear user authentication status
      sessionStorage.removeItem('isAuthenticated');
      router.push({ path: '/'});
    }
  
    
   const visible = ref(false);
  
    const items = ref([
     {  

       label: 'Dashboard',
       icon: 'pi pi-home',
     
     },
     {
       label: 'Reminders',
       icon: 'pi pi-fw pi-pencil',
     },
     {
       label: 'Notifications',
       icon: 'pi pi-bell',
     },
     {
       label: 'Feedbacks',
       icon: 'pi pi-envelope',
     },
     {
       label: 'Events',
       icon: 'pi pi-calendar',
     },
     {
       label: 'Profile',
       icon: 'pi pi-user',
       items: [
              {
               label: 'My info.',
               icon: 'pi pi-verified',
             },
             {
               label: 'log-out',
               icon: 'pi pi-sign-out',
               command: logout
             },
           ],
     },
   ]);

  

   return { visible, items, };
 },
};
</script>


<style scoped>

.drawer-toggle-button {
 background-color: #399c76;
 color: #fff;
 border: none;
 border-radius: 0;
 margin: 0;
 padding: 0.5rem 1rem;
 font-size: 1rem;
 line-height: 1.5;
 text-align: center;
 text-decoration: none;
 cursor: pointer;
 width: 40px;
 height: 40px;
 margin-right: 100px;
}


/* .p-menubar {
    justify-content: center;
    padding: 0.5rem;
    
    color: rgba(255, 255, 255, 0.87);
    border: 1px solid #0b213f;
    border-radius: 6px;
} */
.config-button-container {
    position: absolute;
    top: 0;
    right: 0;
    margin: 10px;
  }





</style>
