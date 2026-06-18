import axios from 'axios'

const api = axios.create({
  baseURL: '/api',
  headers: {
    'Content-Type': 'application/json',
    'Accept': 'application/json',
  },
})

export const getMeja = () => api.get('/meja')

export const createReservasi = (data: any) => api.post('/reservasi', data)

export const getMenus = () => api.get('/menus')

export const createMenu = (data: any) => api.post('/menus', data)

export const staffLogin = (username: string, password: string) =>
  api.post('/staff/login', { username, password })

export const getReservasi = () => api.get('/reservasi')

export const updateReservasi = (id: number, data: any) =>
  api.put(`/reservasi/${id}`, data)

export const deleteReservasi = (id: number) =>
  api.delete(`/reservasi/${id}`)

export const occupyMeja = (id: number) =>
  api.post(`/meja/${id}/occupy`)

export const vacateMeja = (id: number) =>
  api.post(`/meja/${id}/vacate`)

export default api
