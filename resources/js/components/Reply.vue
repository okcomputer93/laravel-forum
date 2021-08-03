
<script>
import Favorite from "./Favorite";
export default {
    name: "Reply.vue",
    props: ['attributes'],
    components: {
      Favorite  
    },
    data() {
        return {
            editing: false,
            body: this.attributes.body
        }
    },
    methods: {
        async update() {
            await axios.patch(`/replies/${this.attributes.id}`, {
                body: this.body
            });

            this.editing = false;

            flash('Updated!');
        },
        async destroy() {
            await axios.delete(`/replies/${this.attributes.id}`)
            flash('Your reply has been deleted.');
            this.$destroy();
            this.$el.parentNode.removeChild(this.$el);
        }
    }
}
</script>

<style>

</style>
