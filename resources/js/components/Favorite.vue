<template>
    <button type="submit"
            :class="classes"
            @click="toggle"
        >
        <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="white" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-heart"><path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"></path></svg>
        <span>{{ count }}</span>
    </button>
</template>

<script>
export default {
    name: "Favorite.vue",
    props: ['reply'],
    data() {
        return {
            active: this.reply.isFavorited,
            count: this.reply.favoritesCount
        }
    },
    computed: {
        classes() {
            return `btn ${this.active ? 'btn-primary' : 'btn-outline-primary' }`;
        },
        endpoint() {
            return `/replies/${this.reply.id}/favorites`;
        }


    },
    methods: {
        async toggle() {
            this.active ? this.destroy() : this.create();
        },
        async destroy() {
            this.active = false;
            await axios.delete(this.endpoint);
            this.count--;
        },
        async create() {
            this.active = true;
            await axios.post(this.endpoint);
            this.count++;
        }
    }
}
</script>

<style scoped>

</style>
