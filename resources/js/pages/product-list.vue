<template>
  <div>
    <section id="products">
        <div class="container">
            <small>Total Records : {{ total_records }}</small>
            <div class="row p-2" v-for="(chunk,index) in chunked" :key="index">
                <div class="col-lg-4 col-sm-4 col-11 offset-sm-0 offset-1" v-for="(product,index) in chunk" :key="index">
                    <div class="card" style="height: auto;">
                        <img class="card-img-top" :src="product.image" alt="Image not found">
                        <div class="card-body">
                          <a :href="product.url" target="_blank" class="text-primary">{{ product.title }}</a>
                          <p class="card-text">{{ product.tagline}}</p>
                          <p class="card-text"><small class="text-muted">By {{ product.authors }}</small></p>
                        </div>
                        <div class="card-footer text-muted" v-if="product.pages">
                          {{ product.pages }} Pages
                        </div>
                    </div>
                </div>
            </div>
        </div>
        </section>
  </div>
</template>

<script>
import _ from 'lodash';


export default {
  layout: 'default',
  name: "ProductList",
  data() {
    return {
      products: [],
      total_records : 0,
    }
  },
  computed: {
    chunked () {
      return _.chunk(this.products, 3)
    },
  },
  methods: {
      getProducts(product_type = "", category="", concept="", published_year= "", language = ""){
          axios.get('/api/product?product_type='+product_type+'&category='+category+'&concept='+concept+'&published_year='+published_year+'&language='+language)
                .then((response)=>{
                  this.products = response.data.data
                  this.total_records = response.data.data.length
                })
      }
  },
  created() {
      this.$root.$refs.ProductListA = this;
      this.getProducts()
  }
}
</script>
