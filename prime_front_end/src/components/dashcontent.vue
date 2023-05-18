<!-- <template>
  <div class="search-container">
    <form @submit.prevent="searchProducts">
      <input class="searchdiv" type="text" v-model="searchTerm" placeholder="Search for food">
      <button class="search-icon " type="submit"><span class="pi pi-search"></span>     Search</button>
    </form>
    <div v-if="loading" class="loading-container">
      <span style="font-size: 30px; margin-right: 5px;">Loading Products</span>
      <i class="pi pi-spin pi-spinner" style="font-size: 2rem;"></i>
    </div>

    <div class="product-container" v-if="products.length">
      <div class="product-card" v-for="product in products" :key="product.code">
        <div class="inside-card">
          <div class="list_product_img_div">
            <img :src="product.image" alt="Product Image">
          </div>
        </div>
        <div class="product-info">
          <p>{{ product.name }}</p>
        </div>
        <button class="favorites" :class="{ clicked: product.isFavorite }" :disabled="product.isFavorite" @click="toggleFavorite(product)">
          {{ product.isFavorite ? 'Favorite Added' : 'Add Favorite' }}
        </button>
      </div>
    </div>

    <div v-else>
      <p style="font-size: 30px;">No products found. Search for food product</p>
    </div>

    <div v-if="selectedProducts.length">
      <h2>Selected Products:</h2>
      <div v-for="product in selectedProducts" :key="product.code">
        <img :src="product.image" alt="Product Image">
        <p>{{ product.name }}</p>
      </div>
    </div>
  </div>
</template>

<script>
/* eslint-disable vue/multi-word-component-names */
import axios from 'axios';
import Button from 'primevue/button';
import { fav_products } from '../store/fav_products.js'


export default {
  name: 'dashcontent',

  contents: {
    Button,
  },
  data() {
    return {
      searchTerm: '',
      products: [],
      loading: false,
      selectedProducts: [] // add a new array to store selected products
     
    }
    
  },
  
  methods: {
    async toggleFavorite(product) {
  product.isFavorite = !product.isFavorite;
  if (product.isFavorite) {
    // add selected product to the selectedProducts array if it is favorited
    this.selectedProducts.push({
      name: product.name,
      image: product.image
    });
    
    // call the addProduct action from the fav_products store and pass the selected product's name and image
    await fav_products.addProduct({ name: product.name, image: product.image });
  } 
  console.log('Selected Products:', this.selectedProducts);
},


    searchProducts() {
      this.loading = true;
      axios.get('https://world.openfoodfacts.org/cgi/search.pl', {
        params: {
          search_terms: this.searchTerm,
          search_simple: 1,
          action: 'process',
          json: 1
        }
      })
      .then(response => {
        const products = response.data.products;
        const productData = products.map(product => ({
          name: product.product_name,
          image: product.image_front_url,
          code: product.code,
          isFavorite: false
        }));
        this.products = productData;
      })
      .catch(error => {
        console.log(error);
      })
      .finally(() => {
        this.loading = false;
      });
    }
  }
}
</script> -->


<template>
  <div class="search-container">
    <form @submit.prevent="searchProducts">
      <input class="searchdiv" type="text" v-model="searchTerm" placeholder="Search for food">
      <button class="search-icon " type="submit"><span class="pi pi-search"></span>     Search</button>
    </form>
    <div v-if="loading" class="loading-container">
      <span style="font-size: 30px; margin-right: 5px;">Loading Products</span>
      <i class="pi pi-spin pi-spinner" style="font-size: 2rem;"></i>
    </div>

    <div class="product-container" v-if="products.length">
      <div class="product-card" v-for="product in products" :key="product.code">
        <div class="inside-card">
          <div class="list_product_img_div">
            <img :src="product.image" alt="Product Image">
          </div>
        </div>
        <div class="product-info">
          <p>{{ product.name }}</p>
        </div>
        <button class="favorites" :class="{ clicked: product.isFavorite }" :disabled="product.isFavorite" @click="toggleFavorite(product)">
          {{ product.isFavorite ? 'Favorite Added' : 'Add Favorite' }}
        </button>
      </div>
    </div>

    <div v-else>
      <p style="font-size: 30px;">No products found. Search for food product</p>
    </div>

    <div  v-if="pages > 1">
  <p class="page-text">Page {{currentPage}} of {{pages}}</p>
  <button class="pagination-button pi pi-chevron-left" @click="prevPage" :disabled="currentPage === 1">    Previous Page</button>
  <button class="pagination-button" @click="nextPage" :disabled="currentPage === pages">Next Page <span class="pi pi-chevron-right" style="color: white; margin-right: 20px; font-size: 20px;"></span></button> 
</div>

    <!-- <div v-if="selectedProducts.length">
      <h2>Selected Products:</h2>
      <div v-for="product in selectedProducts" :key="product.code">
        <img :src="product.image" alt="Product Image">
        <p>{{ product.name }}</p>
      </div>
    </div> -->

   
  </div>
</template>

<script>
/* eslint-disable vue/multi-word-component-names */
import axios from 'axios';
// import Button from 'primevue/button';
import { fav_products } from '../store/fav_products.js'
import { onMounted, watch } from 'vue';

export default {
  name: 'dashcontent',

  components: {
    // Button,
  },
  
  setup() {
  onMounted(() => {
    watch(
      () => fav_products.favorites,
      (newFavorites) => {
        this.selectedProducts = newFavorites;
      },
    );
  });
},

  data() {
  return {
    searchTerm: '',
    products: [],
    loading: false,
    selectedProducts: [],
    currentPage: 1, // add the currentPage property to track the current page
    itemsPerPage: 20, // add the itemsPerPage property to set the number of items per page
    totalItems: 0, // add the totalItems property to store the total number of items returned by the API
    pages: [] // add the pages property to store the pages returned by the API

  }
},


  methods: {
    prevPage() {
  this.currentPage--;
  this.changePage(this.currentPage); 
},

nextPage() {
  this.currentPage++;
  this.changePage(this.currentPage); 
},
    // async toggleFavorite(product) {
    //   product.isFavorite = !product.isFavorite;
    //   if (product.isFavorite) {
    //     this.selectedProducts.push({
    //       fav_product_name: product.name,
    //       fav_product_image: product.image,
    //     });
    //     await fav_products().addProduct({ fav_product_name: product.name, fav_product_image: product.image });
    //   }
    //   console.log('Selected Products:', this.selectedProducts);
    // },




    
    async toggleFavorite(product) {
  product.isFavorite = !product.isFavorite;
  if (product.isFavorite) {
    this.selectedProducts.push({
      fav_product_name: product.name,
      fav_product_image: product.image,
    });
    await fav_products().addProduct({
      fav_product_name: product.name,
      fav_product_image: product.image
    });
  } else {
    const index = this.selectedProducts.findIndex(p => p.fav_product_name === product.name);
    if (index !== -1) {
      this.selectedProducts.splice(index, 1);
      await fav_products().Remove(product.id);
    }
  }
  await fav_products().show_favorites();
},

    async searchProducts() {
      this.loading = true;
     
      const response = await axios.get('https://world.openfoodfacts.org/cgi/search.pl', {
        params: {
          search_terms: this.searchTerm,
          search_simple: 1,
          action: 'process',
          page: 1, // add a 'page' parameter for pagination
          page_size: 20, // add a 'page_size' parameter for pagination
          json: 1
          }
          });
          this.totalItems = response.data.count;
      this.pages = Math.ceil(this.totalItems / this.itemsPerPage);
          const products = response.data.products;
  const productData = products.map(product => ({
    name: product.product_name,
    image: product.image_front_url,
    code: product.code,
    isFavorite: false
  }));
  this.products = productData;
  
  this.loading = false;
},

async changePage(pageNumber) {
  this.loading = true;
  const response = await axios.get('https://world.openfoodfacts.org/cgi/search.pl', {
    params: {
      search_terms: this.searchTerm,
      search_simple: 1,
      action: 'process',
      page: pageNumber,
      page_size: 20,
      json: 1
    }
  });
  
  const products = response.data.products;
  const productData = products.map(product => ({
    name: product.product_name,
    image: product.image_front_url,
    code: product.code,
    isFavorite: false
  }));
  this.products = productData;
  
  this.loading = false;
},

async filterProducts(filter) {
  this.loading = true;
  const response = await axios.get('https://world.openfoodfacts.org/cgi/search.pl', {
    params: {
      search_terms: this.searchTerm,
      search_simple: 1,
      action: 'process',
      page: 1,
      page_size: 20,
      json: 1,
      tagtype_0: 'categories',
      tag_contains_0: 'contains',
      tag_0: filter // add a 'tag_0' parameter for filtering
    }
  });
  
  const products = response.data.products;
  const productData = products.map(product => ({
    name: product.product_name,
    image: product.image_front_url,
    code: product.code,
    isFavorite: false
  }));
  this.products = productData;
  
  this.loading = false;
},

async searchAndFilter(filter) {
  this.loading = true;
  const response = await axios.get('https://world.openfoodfacts.org/cgi/search.pl', {
    params: {
      search_terms: this.searchTerm,
      search_simple: 1,
      action: 'process',
      page: 1,
      page_size: 20,
      json: 1,
      tagtype_0: 'categories',
      tag_contains_0: 'contains',
      tag_0: filter
    }
  });
  
  const products = response.data.products;
  const productData = products.map(product => ({
    name: product.product_name,
    image: product.image_front_url,
    code: product.code,
    isFavorite: false
  }));
  this.products = productData;
  
  this.loading = false;
}
}
}
</script>




<style scoped>

.loading-container {
  display: flex;
  justify-content: center;
  align-items: center;
  height: 500px;
}
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
  z-index: 999;
  box-shadow: 0.25rem 0 1rem rgba(0, 0, 0, 0.15);
}

.layout-config-button i {
  font-size: 2rem;
  line-height: inherit;
  transform: rotate(0deg);
  transition: transform 1s;
}

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



/* Styles for smaller screens */
@media (max-width: 600px) {
  .product-info {
    font-size: 25px; 
    height: auto; 
  }
  form {
    display: contents;
    
}
}

.searchdiv{
  margin-top: -3px;
  margin-right: 3px;
  background-color: #091a32;
  border-radius: 5px;
  height: 40px;
  width: 20rem;
}

.search-icon{
  margin-right: 3px;
  background-color: #091a32;
  border-radius: 5px;
  height: 40px;
  width: 10rem;
}
.search-container {
  margin-top: 20px;
  display: flex;
  flex-direction: column;
  align-items: center;
  justify-content: center;
}


/* test css */
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

.list_product_img_div {
  padding: 20px;
  position: relative;
  display: flex;
  justify-content: center;
  align-self: flex-start;
  height: 200px; /* added */
}

.list_product_img_div img {
  object-fit: contain;
  max-width: 100%;
  max-height: 100%;
  position: absolute;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
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

.product-info {
  font-size: 20px;
  font-weight: 600;
  text-align: center;
  width: 100%;
}

.favorites {
  border-radius: 5px;
  background-color: #0199a4e1;
  transition: background-image 0.5s;
}

.favorites.clicked {
  background-image: linear-gradient(to right, #781BBC, #BA1BBC, #D32F9C);
}

.favorites[disabled] {
 color: white;
}


.pagination-button{
  width: 200px; 
  height: 40px; 
  color: white;
  background-color: #009FA9;
  border-radius: 5px;
  margin-right: 20px; 
  font-size: 20px;
}

.page-text
  {
    font-size: 20px;
    margin-top: 14px;
    margin-bottom: -1px;
    font-weight: 640;
    text-align: center;
}

</style>



   <!-- <div class="contentBG">
      <h1 class="text-center font-bold text-3xl">Product List</h1>
      <button class="layout-config-button" type="button" @click="visible = true">
        <i class="pi pi-cog"></i>
      </button>
    </div> -->
    <!-- <Sidebar v-model:visible="visible" v-if="visible">
      <h2>Sidebar</h2>
      <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p>
    </Sidebar> -->

<!-- 
    .product-image img {
  
      position: absolute; /* absolutely position the image within the container */
      top: 0; /* position the image at the top of the container */
      left: 0; /* position the image at the left of the container */
      width: 100%; /* set the width of the image to 100% */
      height: 100%; /* set the height of the image to 100% */
      object-fit: cover; /* set the object-fit property to cover so that the image fills the container */
      border-radius: 8px;
    }
    
    .product-info {
      font-size: 20px;
      overflow-y: auto;
      padding: 10px;
      text-align: center;
      height: 70px;
      padding-right: 10px;
      white-space: nowrap;
      /* overflow-x: auto; allow horizontal scrolling */
      -webkit-overflow-scrolling: touch; /* enable smooth scrolling on iOS devices */
    } -->
