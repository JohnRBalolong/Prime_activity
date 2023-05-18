<template>
  <div>
    <h2 class="mytext">My Favorites</h2>

    <div class="product-container">
      <div v-if="fav_product.error">
        <div class="px-6 py-4 text-red-500 font-bold text-center">
          {{ fav_product.error }}
        </div>
      </div>
      <div class="fav_card" v-else>
        <div class="product-card" v-for="(product, index) in fav_product.favorites" :key="index">
          <div class="inside-card">
            <div class="list_product_img_div">
              <img :src="product.fav_product_image" alt="Product Image">
            </div>
          </div>
          <div class="product-info">
            <p>{{ product.fav_product_name }}</p>
          </div>

          <button class="editbtn" @click="showDialog(product)">
            Edit
          </button>
          <br>
          <span style="color: rgb(230, 40, 40); cursor: pointer;" class="pi pi-trash" @click="showRemoveDialog(product)">  Delete</span>
        </div>

      </div>
    </div>
    <Dialog v-model:visible="dialogVisible" modal header="Edit Product Name" :style="{ width: '50vw' }" :breakpoints="{ '960px': '75vw', '641px': '100vw' }" @hide="productNameError = false">
      <p>Product ID: {{ editedProductid }}</p>
      <input class="edit_input" v-model="editedProductName">
      <label style="color: rgb(220, 31, 31)" v-if="productNameError" >Product name is required.</label>
      <div class="save-container">
        <button class="save" type="submit" @click="Update">Save</button>
      </div>
    </Dialog>

     <!-- dialog for remove -->
     <Dialog v-model:visible="dialogVisibleRemove" modal header="Are you sure to remove Item?" :style="{ width: '50vw' }" :breakpoints="{ '960px': '75vw', '641px': '100vw' }" >
      <p>Product ID: {{ editedProductid }}</p>  
      <div class="remove_item">
        <button class="remove_btn" type="submit" @click="removeProduct()">Yes</button>
        <button class="remove_btn2" type="submit" @click="dialogVisibleRemove = false">Cancel</button>
      </div>
    </Dialog>

  </div>
</template>

<script>
/* eslint-disable vue/multi-word-component-names */
import { fav_products } from '../store/fav_products.js';
import { onMounted, ref } from 'vue';
import Dialog from 'primevue/dialog';

export default {
  name: 'favorites',
  components: {
    Dialog,
  },

  setup() {
    const fav_product = fav_products();
    const dialogVisible = ref(false);
    const dialogVisibleRemove = ref(false);
    const editedProductName = ref('');
    const editedProductid = ref('');
    const productNameError = ref(false);

    const showDialog = (product) => {
      editedProductName.value = product.fav_product_name;
      editedProductid.value = product.id;
      dialogVisible.value = true;
    };

    const showRemoveDialog = (product) => {
      editedProductName.value = product.fav_product_name;
      editedProductid.value = product.id;
      dialogVisibleRemove.value = true;
    };

    onMounted(() => {
      fav_product.show_favorites();
    });

    return {
      fav_product,
      productNameError,
      editedProductid,
      dialogVisible,
      editedProductName,
      dialogVisibleRemove,
      showDialog,
      showRemoveDialog,
    };
  },

  methods: {
    async removeProduct() {
      // Remove the product here
      const productId = this.editedProductid;
      await fav_products().Remove(productId);

      // Hide the remove dialog
      this.dialogVisibleRemove = false;

       // Reload the list of favorite products
  this.fav_product.show_favorites();
    },





    async Update() {
      var error = false;

      if (this.editedProductName === '') {
        this.productNameError = true;
        error = true;
      } else {
        this.productNameError = false;
      }

      if (error) {
        return;
      } else {
        try {
          const productId = this.editedProductid;
          const productData = {
            fav_product_name: this.editedProductName,
          };

          const formData = new FormData();
          formData.append('fav_product_name', productData.fav_product_name);

          await fav_products().UpdateItem(productId, formData);

          // Hide the dialog
          this.dialogVisible = false;

           // Reload the list of favorite products
      this.fav_product.show_favorites();
        } catch (error) {
          console.error('Error updating product:', error);
          if (error.response && error.response.status === 422) {
            this.productNameError = error.response.data.error;
          }
        }
      }
    },
  },
};
</script>



<style scoped>

.product-container {

  background-color: #091a32;
  display: flex;
  flex-wrap: wrap;
  justify-content: center; 
  margin: 0 -10px;
  overflow: auto;
  margin-left: 40px;
  margin-right: 40px;
  height: 500px;
  border-radius: 5px;
  margin-top: 20px;
}

.product-card {
  position: relative;
  margin-top: 10px;
  padding: 10px;
  background-color: rgb(255, 255, 255);
  border-radius: 8px;
  box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
  display: flex;
  flex-direction: column;
  align-items: center;
  width: 250px;
  max-height: 350px;
  margin-right: 20px;
  margin-bottom: 20px;
}

.mytext{
    margin-top: 30px;
    margin-bottom: -15px;
    color: #0E0424;
    text-align: center;
    
}

.inside-card {
  object-fit: contain;
  /* display: flex; */
  justify-content: center;
  align-items: center;
  width: 100%;
  flex: 1;
  min-height: 150px; /* added */
  min-width: 150px; /* added */
}
.list_product_img_div {
  padding: 20px;
  position: relative;
  display: contents;
  justify-content: center;
  align-self: flex-start;
  height: 200px; /* added */
}

.list_product_img_div img {
  object-fit: contain;
  max-width: 100%;
  max-height: 100%;
  /* position: absolute; */
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
}
.product-info {
  font-size: 20px;
  font-weight: 600;
  text-align: center;
  width: 100%;
}

.fav_card{
  margin-top: 10px;
  padding: 10px;
  border-radius: 8px;
  display: flex;
  margin-bottom: 20px;
  flex-wrap: wrap;
  justify-content: center;
}

.editbtn {
color: #fff;
background: linear-gradient(to right, #20d4a8, #06b3a1, #015f5c);
background: linear-gradient(to bottom right, #20d4a8, #06b3a1, #015f5c) on hover;

border-color: #1ace8a on focus;
outline: none;
border-radius: 0.5rem;
font-weight: 500;
font-size: 0.9rem;

text-align:center;
margin-right: 0.5rem;
margin-bottom: 0.5rem;
box-shadow: 0 4px 6px -1px rgb(47 114 236 / 60%), 0 2px 4px -2px rgb(47 114 236 / 50%);
box-shadow: 0 4px 6px -1px rgb(20 220 168 / 60%), 0 2px 4px -2px rgb(20 220 168 / 50%) on hover;
width: 100px;
}

.p-dialog-content .p-dialog-content-container {
    display: grid;
    place-items: center;
    padding: 20px;
  }

.edit_input[data-v-71602ef7] {
    height: 50px;
    background-clip: content-box;
    width: 100%;
    font-size: 22px
}

.save{

  color: #fff;
background: linear-gradient(to right, #20d4a8, #06b3a1, #015f5c);
background: linear-gradient(to bottom right, #20d4a8, #06b3a1, #015f5c) on hover;

border-color: #1ace8a on focus;
outline: none;
border-radius: 0.5rem;
font-weight: 500;
font-size: 0.9rem;

text-align:center;
margin-right: 0.5rem;
margin-bottom: 0.5rem;
box-shadow: 0 4px 6px -1px rgb(47 114 236 / 60%), 0 2px 4px -2px rgb(47 114 236 / 50%);
box-shadow: 0 4px 6px -1px rgb(20 220 168 / 60%), 0 2px 4px -2px rgb(20 220 168 / 50%) on hover;
width: 100px;
margin-top: 10px;
}

.save-container {
    justify-content: center;
    display: flex;
}

.remove_item{
  justify-content: center;
  display: flex;
}

.remove_btn2{
  margin: 10px;
    color: #fff;
    background: linear-gradient(to right, #d42066, #b306ae, #07015f);
    background: linear-gradient(to bottom right, #20d4a8, #06b3a1, #015f5c) on hover;
    border-color: #1ace8a on focus;
    outline: none;
    border-radius: 0.5rem;
    font-weight: 500;
    font-size: 0.9rem;
    text-align: center;
    margin-right: 0.5rem;
    margin-bottom: 0.5rem;
    box-shadow: 0 4px 6px -1px rgb(47 114 236 / 60%), 0 2px 4px -2px rgb(47 114 236 / 50%);
    box-shadow: 0 4px 6px -1px rgb(20 220 168 / 60%), 0 2px 4px -2px rgb(20 220 168 / 50%) on hover;
    width: 100px;
    margin-top: 10px;

}
.remove_btn{
  margin: 10px;
  color: #fff;
background: linear-gradient(to right, #20d4a8, #06b3a1, #015f5c);
background: linear-gradient(to bottom right, #20d4a8, #06b3a1, #015f5c) on hover;

border-color: #1ace8a on focus;
outline: none;
border-radius: 0.5rem;
font-weight: 500;
font-size: 0.9rem;

text-align:center;
margin-right: 0.5rem;
margin-bottom: 0.5rem;
box-shadow: 0 4px 6px -1px rgb(47 114 236 / 60%), 0 2px 4px -2px rgb(47 114 236 / 50%);
box-shadow: 0 4px 6px -1px rgb(20 220 168 / 60%), 0 2px 4px -2px rgb(20 220 168 / 50%) on hover;
width: 100px;
margin-top: 10px;

}

</style>