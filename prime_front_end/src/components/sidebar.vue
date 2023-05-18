<template>
  <div>
    <Sidebar v-model:visible="visible">
      <h2>App Interaction</h2>
      <p></p>


      <div class="outerdiv">
      <div class="sideList">
        <i class="inside pi pi-chart-line"></i>
        <span class="on_span"> User Analytics</span>
      </div>
      <div class="sideList"> 
        <i class="inside pi pi-book"></i>
        <span >   Development Task</span>
      </div>
      <div class="sideList">
        <i class="inside pi pi-dollar"></i>
        <span >   Earnings</span>
      </div>
      <div class="sideList">
        <i class="inside pi pi-sort-amount-up"></i>
        <span >   liquidation</span>
      </div>
      <div class="sideList">
        <i class="inside pi pi-slack"></i>
        <span >   Chat bot</span>
      </div>
      </div>
    

    </Sidebar>


    <button class="layout-config-button" type="button" @click="visible = true">
      <i class="pi pi-th-large"></i>
    </button>
  </div>
</template>

<script>
import { defineComponent, ref } from 'vue';
import Sidebar from 'primevue/sidebar';

export default defineComponent({
  name: 'MyComponent',
  components: {
    Sidebar,
  },
  setup() {
    const visible = ref(false);
    return {
      visible,
    };
  },
});
</script>

<style scoped>
.contentBG {
  background-color: #DBD1EF;
}
.layout-config-button {
  display: block;
  position: fixed;
  width: 3rem;
  height: 3rem;
  line-height: 3rem;
  background: #009FA9;
  color: white;
  text-align: center;
  top: 50%;
  left: 0;
  margin-top: -1.5rem;
  border-top-right-radius: var(--border-radius);
  border-bottom-right-radius: var(--border-radius);
  border-top-left-radius: 0;
  border-bottom-left-radius: 0;
  transition: background-color var(--transition-duration);
  overflow: hidden;
  cursor: pointer;
  z-index: 2;
  box-shadow: 0.25rem 0 1rem rgba(0, 0, 0, 0.15);
}
.layout-config-button i {
  font-size: 2rem;
  line-height: inherit;
  transform: rotate(0deg);
  transition: transform 1s;
}
.sideList {
  display: flex;
  /* justify-content: center; Center the content horizontally */
  align-items: center; /* Center the content vertically */
  width: inherit;
  height: 40px;
  background-color: #13816f42;
  border-radius: 9px;
  margin-top: 10px;
  cursor: pointer;
}

.outerdiv {
  display: flex;
  flex-direction: column;
  justify-content: center; /* Center the content vertically */
  margin-top: 40px;
}

.sideList:hover {
  background-color: #13816f8f;
}

.inside {
  margin-left: 40px;
    margin-right: 35px;
    font-size: 25px;
}
</style>
