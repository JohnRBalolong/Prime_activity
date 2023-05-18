import { defineStore } from 'pinia';
import axios from 'axios';

export const fav_products = defineStore({
    id: 'fav_products',
    state: () => ({
        error: null,
        favorites: [],
    }),
    actions: {
        async addProduct(productData) {
            try {
                const response = await axios.post('http://127.0.0.1:8000/api/fav_product', productData);
                const product = response.data;
                this.favorites.push(product);
                // Emit the 'added' event
                this.$patch((state) => {
                    state.favorites.push(product);
                });
                // console.log(product);
                return true;
            } catch (error) {
                console.error('Error adding product:', error);
                if (error.response && error.response.status === 422) {
                    this.error = error.response.data.error;
                }
                return false;
            }
        },

        async show_favorites() {
            try {
                const response = await axios.get('http://127.0.0.1:8000/api/fav_product');
                this.$patch((state) => {
                    state.favorites = response.data.products;
                });
                this.error = null;
            } catch (error) {
                console.error('Error fetching products:', error);
                if (error.message === 'Network Error') {
                    this.error = 'Can\'t access the server. Please check your network connection and try again.';
                } else {
                    this.error = 'No product found.';
                }
            }
        },

        async UpdateItem(productId, productData) {
            // console.log(productId);
            try {
                const response = await axios.post(`http://127.0.0.1:8000/api/fav_product/${productId}/update`, productData);
                this.favorites.push(response.data);
                return true;
            } catch (error) {
                console.error('Error updating product:', error);
                if (error.response.status === 422) {
                    this.error = error.response.data.error;
                }
                return false;
            }
        },


        // remove product
        async Remove(productId) {
            //console.log('Removing product with ID:', productId);
            try {
                const response = await axios.delete(`http://127.0.0.1:8000/api/fav_product/${productId}/delete`);
                this.favorites.push(response.data);
                return true;
            } catch (error) {
                console.error('Error deleting product:', error);
                if (error.response.status === 422) {
                    this.error = error.response.data.error;
                }
                return false;
            }
        },









    },
});