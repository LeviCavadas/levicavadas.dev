import { useEffect } from 'react'
import { BrowserRouter, Route, Routes } from 'react-router-dom'
import './App.css'
import HomePage from './pages/HomePage'
import ProjectDetailsPage from './pages/ProjectDetailsPage'
import ProjectDemoPage from './pages/ProjectDemoPage'

const THEME_KEY = 'portfolio-theme'

type ThemeMode = 'light' | 'dark'

const getPreferredTheme = (): ThemeMode => {
  try {
    const storedTheme = localStorage.getItem(THEME_KEY)
    if (storedTheme === 'light' || storedTheme === 'dark') {
      return storedTheme
    }
  } catch {
    // Ignore storage access issues and fall back to the system preference.
  }

  return window.matchMedia('(prefers-color-scheme: dark)').matches ? 'dark' : 'light'
}

const applyTheme = (theme: ThemeMode) => {
  const root = document.documentElement
  root.dataset.theme = theme
  root.style.colorScheme = theme
}

function App() {
  useEffect(() => {
    const mediaQuery = window.matchMedia('(prefers-color-scheme: dark)')
    applyTheme(getPreferredTheme())

    const handleSystemChange = (event: MediaQueryListEvent) => {
      try {
        const savedTheme = localStorage.getItem(THEME_KEY)
        if (!savedTheme) {
          applyTheme(event.matches ? 'dark' : 'light')
        }
      } catch {
        applyTheme(event.matches ? 'dark' : 'light')
      }
    }

    mediaQuery.addEventListener('change', handleSystemChange)

    return () => {
      mediaQuery.removeEventListener('change', handleSystemChange)
    }
  }, [])

  return (
    <BrowserRouter>
      <Routes>
        <Route path="/" element={<HomePage />} />
        <Route path="/projetos/:slug" element={<ProjectDetailsPage />} />
        <Route path="/projetos/:slug/demo" element={<ProjectDemoPage />} />
        <Route path="*" element={<HomePage />} />
      </Routes>
    </BrowserRouter>
  )
}

export default App
