<template>
      <slider animation="fade">
            <p style="line-height: 280px; font-size: 5rem; text-align: center;" v-if="!list.length">Loading...</p>
            <slider-item v-for="(slider, index) in list" :key="index" :on-click="test">
                <a :href="slider.link" :title="slider.name">
                    <img :src="`/${slider.image}`" :alt="slider.name" 
                        style="width: 735px; height: 280px"
                    />                
                </a>
            </slider-item>
        </slider>
</template>

<script>
import { Slider, SliderItem } from 'vue-easy-slider'

export default {
    name: 'user-slider',

    components: { 'slider': Slider, 'slider-item': SliderItem },
    methods: {
        test () {console.log(1)}
    },
    data () {
        return {
            list: []
        }
    },

    async mounted() {
        let response = await axios.get('/sliders')
        
        if (response.status == 200) {
            console.log(response)
            return this.list = response.data          
        }
  },
}
</script>

