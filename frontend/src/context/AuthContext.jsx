import { createContext, useContext, useMemo, useState } from 'react';
import api from '../services/api';

const AuthContext = createContext(null);
export function AuthProvider({ children }) {
  const [user, setUser] = useState(() => { try { return JSON.parse(localStorage.getItem('stride_user')); } catch { return null; } });
  async function login(credentials) { const { data } = await api.post('/login', credentials); localStorage.setItem('stride_token', data.token); localStorage.setItem('stride_user', JSON.stringify(data.user)); setUser(data.user); return data.user; }
  async function register(payload) { const { data } = await api.post('/register', payload); localStorage.setItem('stride_token', data.token); localStorage.setItem('stride_user', JSON.stringify(data.user)); setUser(data.user); return data.user; }
  async function logout() { try { await api.post('/logout'); } finally { localStorage.removeItem('stride_token'); localStorage.removeItem('stride_user'); setUser(null); } }
  const value = useMemo(() => ({ user, role: user?.role, login, register, logout }), [user]);
  return <AuthContext.Provider value={value}>{children}</AuthContext.Provider>;
}
export const useAuth = () => useContext(AuthContext);
