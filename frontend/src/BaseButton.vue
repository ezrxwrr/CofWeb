<template>
  <button 
    :class="['base-btn', `btn-${variant}`]" 
    :style="{ borderRadius: customRadius }"
    :disabled="disabled" 
    @click="$emit('click')"
  >
    <slot></slot>
  </button>
</template>

<script setup lang="ts">
defineProps({
  variant: { type: String, default: 'primary' },
  disabled: { type: Boolean, default: false },
  customRadius: { type: String, default: '30px' }
})
defineEmits(['click'])
</script>

<style scoped>
.base-btn {
  width: 100%;
  padding: 16px;
  font-weight: 600;
  font-size: 0.95rem;
  cursor: pointer;
  text-align: center;
  /* ANIMATION: Scales down and fades slightly on click */
  transition: transform 0.2s cubic-bezier(0.4, 0, 0.2, 1), opacity 0.2s ease;
  display: block;
}

.base-btn:active:not(:disabled) {
  transform: scale(0.96);
  opacity: 0.85; /* The Fade-in click effect */
}

.base-btn:disabled {
  cursor: not-allowed;
  opacity: 0.6;
}

.btn-primary { background-color: #4A5837 !important; color: #FFFFFF !important; border: none; }
.btn-outline { background-color: transparent !important; color: #4A5837 !important; border: 1px solid #4A5837 !important; }
</style>