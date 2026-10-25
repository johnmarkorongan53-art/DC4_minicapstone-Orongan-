import axios from 'axios';

const api = axios.create({ baseURL: import.meta.env.VITE_API_URL || 'http://localhost:8000/api', headers: { Accept: 'application/json' } });
api.interceptors.request.use((config) => { const token = localStorage.getItem('stride_token'); if (token) config.headers.Authorization = `Bearer ${token}`; return config; });
api.interceptors.response.use((r) => r, (error) => { if (error.response?.status === 401) { localStorage.removeItem('stride_token'); localStorage.removeItem('stride_user'); if (!location.pathname.startsWith('/login')) location.assign('/login'); } return Promise.reject(error); });
export default api;
