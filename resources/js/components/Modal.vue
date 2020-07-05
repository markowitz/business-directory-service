<template>
<div class="container-fluid">
  <div class="modal fade" v-if="active" id="showModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document" @click.stop :style="{maxWidth: options.width}">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">
          {{title}}
        </h5>
        <span class="close" @click="$emit('close'); active=false">&times;</span>
      </div>
      <div class="modal-body">
          <slot></slot>
      </div>
    </div>
  </div>
  </div>
</div>
</template>

<script>
export default {
  data() {
    return {
      showModal: false,
      active: false,
    };
  },
  props: {
    Description: { type: String, required: false },
    title: { type: String, required: false },
    withButton: { type: Boolean, required: false, default: true },
    minimize: { type: Boolean, required: false, default: true },
    id: { type: String, required: false },
    options: {
      type: Object,
      required: false,
      default() {
        return { width: '500px' };
      },
    },
  },
};
</script>

<style scoped>
  #showModal {
    display: block;
    opacity: 1;
    overflow: auto;
  }
  .close {
    cursor: pointer;
  }
  .modal {
      background-color: rgba(0,0,0,0.7);
  }
</style>
