<template>
  <div>
    <section id="sidebar">
        <div>
            <h6 class="p-1 border-bottom">Filter By</h6>
            <p class="mb-2">Category</p>
            <ul class="list-group">
                <li v-for="(category,index) in filters.categories" :key="index">
                  <div class="form-check form-check-inline">
                    <input class="form-check-input" type="checkbox" :value="category.category" @click="FilterProducts('category',$event)">
                    <label class="form-check-label" for="inlineCheckbox1">{{ category.category }} ({{ category.total }})</label>
                  </div>
                </li>
            </ul>
        </div>
        <hr>
        <div>
            <p class="mb-2">Product Type</p>
            <ul class="list-group">
                <li v-for="(type,index) in filters.product_type" :key="index">
                  <div class="form-check form-check-inline">
                    <input class="form-check-input" type="checkbox" :value="type.product_type" @click="FilterProducts('product_type',$event)">
                    <label class="form-check-label" for="inlineCheckbox1">{{ type.product_type }} ({{ type.total }})</label>
                  </div>
                </li>
            </ul>
        </div>
        <hr>
        <div>
            <p class="mb-2">Published Year</p>
            <ul class="list-group">
                <li v-for="(published_year,index) in filters.published_years" :key="index">
                  <div class="form-check form-check-inline">
                    <input class="form-check-input" type="checkbox" :value="published_year.published_year" @click="FilterProducts('published_year',$event)">
                    <label class="form-check-label" for="inlineCheckbox1">{{ published_year.published_year }}</label>
                  </div>
                </li>
            </ul>
        </div>
        <hr>
        <div>
            <p class="mb-2">Concept</p>
            <ul class="list-group">
                <li v-for="(concept,index) in filters.concepts" :key="index">
                  <div class="form-check form-check-inline">
                    <input class="form-check-input" type="checkbox" :value="concept.concept" @click="FilterProducts('concept',$event)">
                    <label class="form-check-label" for="inlineCheckbox1">{{ concept.concept }} ({{ concept.total }})</label>
                  </div>
                </li>
            </ul>
        </div>
        <hr>
        <div>
            <p class="mb-2">Languages</p>
            <ul class="list-group">
                <li v-for="(language,index) in filters.languages" :key="index">
                  <div class="form-check form-check-inline">
                    <input class="form-check-input" type="checkbox" :value="language.language" @click="FilterProducts('language',$event)">
                    <label class="form-check-label" for="inlineCheckbox1">{{ language.language }} ({{ language.total }})</label>
                  </div>
                </li>
            </ul>
        </div>
    </section>
    </div>
</template>

<script>
export default {
  name: 'SideBar',
  data() {
    return {
      filters: [],
      filterCategory: [],
      filterProductType: [],
      filterConcept: [],
      filterPublishedYear: [],
      filterLanguage: [],
    }
  },
  methods: {
      getProductFilters(){
          axios.get('/api/product/filters')
                .then((response)=>{
                  this.filters = response.data.data
                })
      },
      FilterProducts(type, e) {
        var checkbox_value = e.target.value;
        if (e.target.checked) {
          if (type == "category") {
            this.filterCategory.push(checkbox_value);
          }
          if (type == "product_type") {
            this.filterProductType.push(checkbox_value);
          }
          if (type == "concept") {
            this.filterConcept.push(checkbox_value);
          }
          if (type == "published_year") {
            this.filterPublishedYear.push(checkbox_value);
          }
          if (type == "language") {
            this.filterLanguage.push(checkbox_value);
          }


        } else {
          if (type == "category") {
            this.filterCategory = _.without(this.filterCategory, checkbox_value);
          }
          if (type == "product_type") {
            this.filterProductType = _.without(this.filterProductType, checkbox_value);
          }
          if (type == "concept") {
            this.filterConcept = _.without(this.filterConcept, checkbox_value);
          }
          if (type == "published_year") {
            this.filterPublishedYear = _.without(this.filterPublishedYear, checkbox_value);
          }
          if (type == "language") {
            this.filterLanguage = _.without(this.filterLanguage, checkbox_value);
          }
        }
        this.$root.$refs.ProductListA.getProducts(this.filterProductType,this.filterCategory, this.filterConcept,this.filterPublishedYear,this.filterLanguage);
      }
  },
  created() {
      this.getProductFilters()
  }
}
</script>
