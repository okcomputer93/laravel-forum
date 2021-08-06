<template>
    <div>
        <div v-for="(reply, index) in items">
            <reply :data="reply" @deleted="remove(index)"></reply>
        </div>

        <new-reply :action="endpoint" @created="add"></new-reply>

    </div>
</template>

<script>
import Reply from "./Reply";
import NewReply from "./NewReply";
export default {
    name: "Replies.vue",
    props: ['data'],
    components: {
        Reply,
        NewReply
    },
    data() {
        return {
            items: this.data
        }
    },
    computed: {
        endpoint() {
            return `${location.pathname}/replies`;
        }
    },
    methods: {
        remove(index) {
            this.items.splice(index, 1);
            this.$emit('removed')
            flash('Reply was deleted');
        },
        add(reply) {
            this.items.push(reply);
            this.$emit('added')
        }
    }
}
</script>

<style scoped>

</style>
