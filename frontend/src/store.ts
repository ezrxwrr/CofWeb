import { reactive } from 'vue'

export const globalStore = reactive({
  currentView: 'Home',
  
  // STATE BARU: Status Login
  isStaff: false,
  staffName: '',

  reservation: {
    id_reservasi: null as number | null,
    name: '',
    contact: '', 
    pax: 2,
    time: '11:00',
    date: '', 
    tables: [] as string[],
  },

  cart: [] as any[],
  subtotal: 0,
  tax: 0,
  total: 0,

  payment: {
    status: 'PENDING', 
    cancelReason: '', 
  },

  currentReceiptCode: '',
  history: [] as any[]
})