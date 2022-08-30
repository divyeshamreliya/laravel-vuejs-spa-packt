<template>
  <div>
    <nav class="navbar navbar-expand-sm navbar-light bg-white border-bottom">
          <a class="navbar-brand ml-2 font-weight-bold" href="https://www.packtpub.com/" target="_blank">Packt</a>
          <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarColor" aria-controls="navbarColor" aria-expanded="false" aria-label="Toggle navigation">
              <span class="navbar-toggler-icon"></span>
          </button>
          <div class="collapse navbar-collapse" id="navbarColor">
              <ul class="navbar-nav">
                  <li class="nav-item">
                    <a class="nav-link active"  @click="getProducts('')">All</a>
                  </li>
                  <li class="nav-item" v-for="(product_type,index) in product_types" :key="index">
                    <a class="nav-link"  id="product_type.product_type" @click="getProducts(product_type.product_type)">{{ product_type.product_type }}</a>
                  </li>
              </ul>
          </div>
      </nav>
    </div>
</template>

<script>
export default {
  name: 'Head',
  data() {
    return {
      product_types: [],
    }
  },
  methods: {
      getProductType(){
          axios.get('/api/product/type')
                .then((response)=>{
                  this.product_types = response.data.data
                })
      },
      getProducts(product_type){
        this.$root.$refs.ProductListA.getProducts(product_type);
      }
  },
  created() {
      this.getProductType()
  }
}
</script>
