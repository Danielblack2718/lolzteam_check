<template>
    <transition name="fade">
        <div v-if="isVisible" class="modal">
            <div class="modal__content">
                <div class="modal__top">
                    <h2>{{ title }}</h2>
                    <button @click="closeModal">X</button>
                </div>
                <div class="modal__body">
                    <slot>
                    </slot>
                </div>

            </div>
        </div>
    </transition>
</template>
  
<script>
export default {
    name: "MModal", props: {
        title: String
    },
    data() {
        return {
            isVisible: false
        };
    },
    methods: {
        closeModal() {
            this.isVisible = false;
            this.$emit('close');
        }
    },
    mounted() {
        this.isVisible = true;
    }
};
</script>
  
  