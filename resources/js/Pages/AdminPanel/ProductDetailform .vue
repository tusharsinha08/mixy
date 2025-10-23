<template>
  <div class="p-6 admin-product-detail-form">
    <div class="mb-6">
      <h1 class="text-2xl font-bold text-gray-900">Product Detail Page Editor</h1>
      <p class="text-gray-600">Manage product details, images, reviews, and related products</p>
    </div>

    <form @submit.prevent="saveProductDetail" class="space-y-8">
      <!-- Basic Product Information -->
      <div class="p-6 bg-white rounded-lg shadow-md">
        <h2 class="mb-4 text-xl font-semibold text-gray-900">Basic Information</h2>
        <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
          <div>
            <label class="block mb-2 text-sm font-medium text-gray-700">Product Name *</label>
            <input
              v-model="formData.name"
              type="text"
              required
              class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-green-500"
              placeholder="Single product One"
            >
          </div>
          <div>
            <label class="block mb-2 text-sm font-medium text-gray-700">Product ID</label>
            <input
              v-model="formData.id"
              type="number"
              class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-green-500"
              placeholder="1"
            >
          </div>
          <div>
            <label class="block mb-2 text-sm font-medium text-gray-700">Price Range *</label>
            <input
              v-model="formData.priceRange"
              type="text"
              required
              class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-green-500"
              placeholder="$10.00 - $20.00"
            >
          </div>
          <div>
            <label class="block mb-2 text-sm font-medium text-gray-700">Rating (1-5)</label>
            <select
              v-model="formData.rating"
              class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-green-500"
            >
              <option value="1">1 Star</option>
              <option value="2">2 Stars</option>
              <option value="3">3 Stars</option>
              <option value="4">4 Stars</option>
              <option value="5">5 Stars</option>
            </select>
          </div>
        </div>
      </div>

      <!-- Product Images -->
      <div class="p-6 bg-white rounded-lg shadow-md">
        <h2 class="mb-4 text-xl font-semibold text-gray-900">Product Images</h2>
        <div class="space-y-4">
          <div>
            <label class="block mb-2 text-sm font-medium text-gray-700">Primary Image URL *</label>
            <input
              v-model="formData.imagePrimary"
              type="text"
              required
              class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-green-500"
              placeholder="/assets/images/products/product-image-2-1.jpg"
            >
            <p class="mt-1 text-xs text-gray-500">Main product image displayed at the top</p>
          </div>
          <div>
            <label class="block mb-2 text-sm font-medium text-gray-700">Thumbnail Images</label>
            <div class="space-y-2">
              <div v-for="(thumbnail, index) in formData.thumbnails" :key="index" class="flex space-x-2">
                <input
                  v-model="formData.thumbnails[index]"
                  type="text"
                  class="flex-1 px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-green-500"
                  placeholder="Thumbnail image URL"
                >
                <button
                  type="button"
                  @click="removeThumbnail(index)"
                  class="px-3 py-2 text-red-600 bg-red-100 border border-red-300 rounded-md hover:bg-red-200"
                >
                  Remove
                </button>
              </div>
              <button
                type="button"
                @click="addThumbnail"
                class="px-4 py-2 text-green-600 bg-green-100 border border-green-300 rounded-md hover:bg-green-200"
              >
                + Add Thumbnail
              </button>
            </div>
          </div>
        </div>
      </div>

      <!-- Product Descriptions -->
      <div class="p-6 bg-white rounded-lg shadow-md">
        <h2 class="mb-4 text-xl font-semibold text-gray-900">Product Descriptions</h2>
        <div class="space-y-4">
          <div>
            <label class="block mb-2 text-sm font-medium text-gray-700">Short Description</label>
            <textarea
              v-model="formData.descriptionShort"
              rows="3"
              class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-green-500"
              placeholder="Brief product description that appears below the title..."
            ></textarea>
          </div>
          <div>
            <label class="block mb-2 text-sm font-medium text-gray-700">Long Description</label>
            <textarea
              v-model="formData.descriptionLong"
              rows="6"
              class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-green-500"
              placeholder="Full product description for the Description tab..."
            ></textarea>
          </div>
        </div>
      </div>

      <!-- Product Attributes -->
      <div class="p-6 bg-white rounded-lg shadow-md">
        <h2 class="mb-4 text-xl font-semibold text-gray-900">Product Attributes</h2>
        <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
          <!-- Sizes -->
          <div>
            <label class="block mb-2 text-sm font-medium text-gray-700">Available Sizes</label>
            <div class="space-y-2">
              <div v-for="(size, index) in formData.sizes" :key="index" class="flex space-x-2">
                <input
                  v-model="formData.sizes[index]"
                  type="text"
                  class="flex-1 px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-green-500"
                  placeholder="Size (e.g., S, M, L)"
                >
                <button
                  type="button"
                  @click="removeSize(index)"
                  class="px-3 py-2 text-red-600 bg-red-100 border border-red-300 rounded-md hover:bg-red-200"
                >
                  Remove
                </button>
              </div>
              <button
                type="button"
                @click="addSize"
                class="px-4 py-2 text-green-600 bg-green-100 border border-green-300 rounded-md hover:bg-green-200"
              >
                + Add Size
              </button>
            </div>
          </div>

          <!-- Categories & Tags -->
          <div class="space-y-4">
            <div>
              <label class="block mb-2 text-sm font-medium text-gray-700">Categories</label>
              <input
                v-model="formData.categoriesInput"
                type="text"
                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-green-500"
                placeholder="Fruits, Snacks (comma separated)"
                @blur="updateCategories"
              >
            </div>
            <div>
              <label class="block mb-2 text-sm font-medium text-gray-700">Tags</label>
              <input
                v-model="formData.tagsInput"
                type="text"
                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-green-500"
                placeholder="Organic, Healthy (comma separated)"
                @blur="updateTags"
              >
            </div>
          </div>
        </div>
      </div>

      <!-- Additional Information -->
      <div class="p-6 bg-white rounded-lg shadow-md">
        <h2 class="mb-4 text-xl font-semibold text-gray-900">Additional Information</h2>
        <p class="mb-4 text-sm text-gray-600">This information appears in the "Additional Information" tab</p>
        <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
          <div>
            <label class="block mb-2 text-sm font-medium text-gray-700">Size Details</label>
            <input
              v-model="formData.additionalInfo.size"
              type="text"
              class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-green-500"
              placeholder="1kg, 200g, 500g"
            >
          </div>
          <div>
            <label class="block mb-2 text-sm font-medium text-gray-700">Brand</label>
            <input
              v-model="formData.additionalInfo.brand"
              type="text"
              class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-green-500"
              placeholder="Skinfood"
            >
          </div>
          <div class="md:col-span-2">
            <label class="block mb-2 text-sm font-medium text-gray-700">Dietary & Lifestyle</label>
            <input
              v-model="formData.additionalInfo.dietary_and_lifestyle"
              type="text"
              class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-green-500"
              placeholder="Vegan, Gluten-Free, etc."
            >
          </div>
        </div>
      </div>

      <!-- Customer Reviews -->
      <div class="p-6 bg-white rounded-lg shadow-md">
        <h2 class="mb-4 text-xl font-semibold text-gray-900">Customer Reviews</h2>
        <div class="space-y-4">
          <div v-for="(review, index) in formData.reviews" :key="index" class="p-4 border border-gray-200 rounded-lg">
            <div class="flex items-center justify-between mb-3">
              <h3 class="font-medium text-gray-900">Review {{ index + 1 }}</h3>
              <button
                type="button"
                @click="removeReview(index)"
                class="text-red-600 hover:text-red-800"
              >
                Remove
              </button>
            </div>
            <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
              <div>
                <label class="block mb-1 text-sm text-gray-600">Customer Name</label>
                <input
                  v-model="review.name"
                  type="text"
                  class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-green-500"
                >
              </div>
              <div>
                <label class="block mb-1 text-sm text-gray-600">Rating (1-5)</label>
                <select
                  v-model="review.rating"
                  class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-green-500"
                >
                  <option value="1">1 Star</option>
                  <option value="2">2 Stars</option>
                  <option value="3">3 Stars</option>
                  <option value="4">4 Stars</option>
                  <option value="5">5 Stars</option>
                </select>
              </div>
              <div class="md:col-span-2">
                <label class="block mb-1 text-sm text-gray-600">Comment</label>
                <textarea
                  v-model="review.comment"
                  rows="2"
                  class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-green-500"
                ></textarea>
              </div>
              <div>
                <label class="block mb-1 text-sm text-gray-600">Date</label>
                <input
                  v-model="review.date"
                  type="text"
                  class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-green-500"
                  placeholder="Nov 10, 2022"
                >
              </div>
            </div>
          </div>
          <button
            type="button"
            @click="addReview"
            class="px-4 py-2 text-green-600 bg-green-100 border border-green-300 rounded-md hover:bg-green-200"
          >
            + Add Review
          </button>
        </div>
      </div>

      <!-- Related Products -->
      <div class="p-6 bg-white rounded-lg shadow-md">
        <h2 class="mb-4 text-xl font-semibold text-gray-900">Related Products</h2>
        <p class="mb-4 text-sm text-gray-600">Products that appear in the "Related Products" section</p>
        <div class="space-y-4">
          <div v-for="(relatedProduct, index) in formData.relatedProducts" :key="index" class="p-4 border border-gray-200 rounded-lg">
            <div class="flex items-center justify-between mb-3">
              <h3 class="font-medium text-gray-900">Related Product {{ index + 1 }}</h3>
              <button
                type="button"
                @click="removeRelatedProduct(index)"
                class="text-red-600 hover:text-red-800"
              >
                Remove
              </button>
            </div>
            <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
              <div>
                <label class="block mb-1 text-sm text-gray-600">Product Name</label>
                <input
                  v-model="relatedProduct.name"
                  type="text"
                  class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-green-500"
                >
              </div>
              <div>
                <label class="block mb-1 text-sm text-gray-600">Product ID</label>
                <input
                  v-model="relatedProduct.id"
                  type="number"
                  class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-green-500"
                >
              </div>
              <div>
                <label class="block mb-1 text-sm text-gray-600">Image URL</label>
                <input
                  v-model="relatedProduct.imagePrimary"
                  type="text"
                  class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-green-500"
                >
              </div>
              <div>
                <label class="block mb-1 text-sm text-gray-600">Price Range</label>
                <input
                  v-model="relatedProduct.priceRange"
                  type="text"
                  class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-green-500"
                >
              </div>
              <div>
                <label class="block mb-1 text-sm text-gray-600">Rating (1-5)</label>
                <select
                  v-model="relatedProduct.rating"
                  class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-green-500"
                >
                  <option value="1">1 Star</option>
                  <option value="2">2 Stars</option>
                  <option value="3">3 Stars</option>
                  <option value="4">4 Stars</option>
                  <option value="5">5 Stars</option>
                </select>
              </div>
            </div>
          </div>
          <button
            type="button"
            @click="addRelatedProduct"
            class="px-4 py-2 text-green-600 bg-green-100 border border-green-300 rounded-md hover:bg-green-200"
          >
            + Add Related Product
          </button>
        </div>
      </div>

      <!-- Tab Settings -->
      <div class="p-6 bg-white rounded-lg shadow-md">
        <h2 class="mb-4 text-xl font-semibold text-gray-900">Tab Settings</h2>
        <div class="space-y-4">
          <div>
            <label class="block mb-2 text-sm font-medium text-gray-700">Available Tabs</label>
            <div class="space-y-2">
              <div v-for="(tab, index) in formData.tabs" :key="index" class="flex items-center space-x-2">
                <input
                  v-model="formData.tabs[index]"
                  type="text"
                  class="flex-1 px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-green-500"
                  placeholder="Tab name"
                >
                <button
                  type="button"
                  @click="removeTab(index)"
                  class="px-3 py-2 text-red-600 bg-red-100 border border-red-300 rounded-md hover:bg-red-200"
                >
                  Remove
                </button>
              </div>
              <button
                type="button"
                @click="addTab"
                class="px-4 py-2 text-green-600 bg-green-100 border border-green-300 rounded-md hover:bg-green-200"
              >
                + Add Tab
              </button>
            </div>
          </div>
          <div>
            <label class="block mb-2 text-sm font-medium text-gray-700">Default Active Tab</label>
            <select
              v-model="formData.activeTab"
              class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-green-500"
            >
              <option v-for="tab in formData.tabs" :key="tab" :value="tab">{{ tab }}</option>
            </select>
          </div>
        </div>
      </div>

      <!-- Action Buttons -->
      <div class="flex justify-end space-x-4">
        <button
          type="button"
          @click="resetForm"
          class="px-6 py-2 text-gray-700 bg-gray-200 border border-gray-300 rounded-md hover:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-gray-500"
        >
          Reset
        </button>
        <button
          type="submit"
          class="px-6 py-2 text-white bg-green-600 border border-transparent rounded-md hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500"
        >
          Save Product Details
        </button>
      </div>
    </form>

    <!-- Success Message -->
    <div v-if="showSuccess" class="p-4 mt-6 text-green-800 bg-green-100 border border-green-400 rounded-md">
      Product details updated successfully!
    </div>

    <!-- Preview Section -->
    <div class="p-6 mt-12 rounded-lg bg-gray-50">
      <h2 class="mb-4 text-xl font-semibold text-gray-900">Preview</h2>
      <div class="mb-4 text-sm text-gray-600">
        Home > Single Product
      </div>
      <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
        <div class="p-4 bg-white border rounded">
          <img :src="formData.imagePrimary || '/placeholder-image.jpg'" alt="Preview" class="object-contain w-full h-40 mb-2 rounded">
          <div class="flex space-x-2 overflow-x-auto">
            <img 
              v-for="(thumb, index) in formData.thumbnails" 
              :key="index" 
              :src="thumb || '/placeholder-thumb.jpg'" 
              alt="Thumbnail"
              class="flex-shrink-0 object-contain w-12 h-12 border rounded"
            >
          </div>
        </div>
        <div class="p-4 bg-white border rounded">
          <h3 class="mb-2 font-bold">{{ formData.name || 'Product Name' }}</h3>
          <p class="mb-2 text-sm text-gray-600">{{ formData.descriptionShort || 'Short description...' }}</p>
          <p class="font-bold text-red-600">{{ formData.priceRange || '$0.00' }}</p>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: 'ProductDetailForm',
  data() {
    return {
      showSuccess: false,
      formData: {
        id: 1,
        name: 'Single product One',
        imagePrimary: '/assets/images/products/product-image-2-1.jpg',
        thumbnails: [
          '/assets/images/products/product-image-2-1.jpg',
          '/assets/images/products/product-image-2-2.jpg',
          '/assets/images/products/product-image-2-3.jpg'
        ],
        rating: 4,
        priceRange: '$10.00 - $20.00',
        descriptionShort: 'Lorem ipsum dolor sit amet, consectetur adipiscing elit.',
        descriptionLong: 'Full product description goes here. Include all details about the product.',
        additionalInfo: {
          size: '1kg, 200g, 500g',
          brand: 'Skinfood',
          dietary_and_lifestyle: 'Vegan'
        },
        reviews: [
          { name: 'Mike B', rating: 5, comment: 'Excellent product!', date: 'Nov 10, 2022' },
          { name: 'Alice W', rating: 4, comment: 'Good quality.', date: 'Nov 12, 2022' }
        ],
        categories: ['Fruits', 'Snacks'],
        tags: ['Organic', 'Healthy'],
        sizes: ['S', 'M', 'L'],
        relatedProducts: [
          { id: 2, name: 'Dried mango', imagePrimary: '/assets/images/products/product-image-1-1.jpg', rating: 4, priceRange: '$10.00 - $70.00' },
          { id: 3, name: 'Banana chips', imagePrimary: '/assets/images/products/product-image-3-1.jpg', rating: 4, priceRange: '$15.00 - $50.00' },
          { id: 4, name: 'Red Dates', imagePrimary: '/assets/images/products/product-image-4-1.jpg', rating: 4, priceRange: '$20.00 - $60.00' },
          { id: 5, name: 'Cranberries', imagePrimary: '/assets/images/products/product-image-5-1.jpg', rating: 4, priceRange: '$25.00 - $70.00' },
          { id: 6, name: 'Kiwi', imagePrimary: '/assets/images/products/product-image-6-1.jpg', rating: 4, priceRange: '$30.00 - $80.00' },
        ],
        categoriesInput: 'Fruits, Snacks',
        tagsInput: 'Organic, Healthy',
        tabs: ['Description', 'Additional Information', 'Reviews'],
        activeTab: 'Description'
      }
    }
  },
  methods: {
    async saveProductDetail() {
      try {
        // Here you would typically make an API call to save the product data
        console.log('Saving product detail data:', this.formData);
        
        // Simulate API call
        await new Promise(resolve => setTimeout(resolve, 1000));
        
        this.showSuccess = true;
        setTimeout(() => {
          this.showSuccess = false;
        }, 3000);
        
      } catch (error) {
        console.error('Error saving product detail data:', error);
        alert('Error saving product details. Please try again.');
      }
    },
    
    resetForm() {
      if (confirm('Are you sure you want to reset all changes?')) {
        this.formData = { ...this.$options.data().formData };
      }
    },
    
    addThumbnail() {
      this.formData.thumbnails.push('');
    },
    
    removeThumbnail(index) {
      this.formData.thumbnails.splice(index, 1);
    },
    
    addSize() {
      this.formData.sizes.push('');
    },
    
    removeSize(index) {
      this.formData.sizes.splice(index, 1);
    },
    
    updateCategories() {
      this.formData.categories = this.formData.categoriesInput.split(',').map(cat => cat.trim()).filter(cat => cat);
    },
    
    updateTags() {
      this.formData.tags = this.formData.tagsInput.split(',').map(tag => tag.trim()).filter(tag => tag);
    },
    
    addReview() {
      this.formData.reviews.push({
        name: '',
        rating: 5,
        comment: '',
        date: new Date().toLocaleDateString('en-US', { month: 'short', day: 'numeric', year: 'numeric' })
      });
    },
    
    removeReview(index) {
      this.formData.reviews.splice(index, 1);
    },
    
    addRelatedProduct() {
      this.formData.relatedProducts.push({
        id: this.formData.relatedProducts.length + 2,
        name: '',
        imagePrimary: '',
        rating: 4,
        priceRange: ''
      });
    },
    
    removeRelatedProduct(index) {
      this.formData.relatedProducts.splice(index, 1);
    },
    
    addTab() {
      this.formData.tabs.push('');
    },
    
    removeTab(index) {
      if (this.formData.tabs.length > 1) {
        this.formData.tabs.splice(index, 1);
        if (this.formData.activeTab === this.formData.tabs[index]) {
          this.formData.activeTab = this.formData.tabs[0];
        }
      }
    }
  },
  
  mounted() {
    // Initialize input fields from arrays
    this.formData.categoriesInput = this.formData.categories.join(', ');
    this.formData.tagsInput = this.formData.tags.join(', ');
  }
}
</script>

<style scoped>
.admin-product-detail-form {
  max-width: 1200px;
  margin: 0 auto;
}
</style>