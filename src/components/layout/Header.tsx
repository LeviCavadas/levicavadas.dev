import { useEffect, useState } from 'react'
import { Link } from 'react-router-dom'
import { siteConfig } from '../../data/site'

const navItems = [
  { label: 'Home', href: '/#inicio' },
  { label: 'Sobre', href: '/#sobre' },
  { label: 'Experiência', href: '/#experiencia' },
  { label: 'Projetos', href: '/#projetos' },
  { label: 'Tecnologias', href: '/#tecnologias' },
  { label: 'GitHub', href: '/#github' },
  { label: 'LinkedIn', href: '/#linkedin' },
  { label: 'Contato', href: '/#contato' },
]

const THEME_KEY = 'portfolio-theme'

type ThemeMode = 'light' | 'dark'

const getStoredTheme = (): ThemeMode | null => {
  try {
    const storedTheme = localStorage.getItem(THEME_KEY)
    if (storedTheme === 'light' || storedTheme === 'dark') {
      return storedTheme
    }
  } catch {
    return null
  }

  return null
}

const getSystemTheme = (): ThemeMode =>
  window.matchMedia('(prefers-color-scheme: dark)').matches ? 'dark' : 'light'

export function Header() {
  const [menuOpen, setMenuOpen] = useState(false)
  const [theme, setTheme] = useState<ThemeMode>(() => {
    if (typeof window === 'undefined') {
      return 'light'
    }

    return getStoredTheme() ?? getSystemTheme()
  })

  useEffect(() => {
    const root = document.documentElement
    root.dataset.theme = theme
    root.style.colorScheme = theme

    try {
      localStorage.setItem(THEME_KEY, theme)
    } catch {
      // Ignore storage access failures and keep the current theme visible in the UI.
    }
  }, [theme])

  useEffect(() => {
    const mediaQuery = window.matchMedia('(prefers-color-scheme: dark)')

    const handleSystemPreference = (event: MediaQueryListEvent) => {
      if (!getStoredTheme()) {
        const nextTheme: ThemeMode = event.matches ? 'dark' : 'light'
        setTheme(nextTheme)
      }
    }

    mediaQuery.addEventListener('change', handleSystemPreference)

    return () => {
      mediaQuery.removeEventListener('change', handleSystemPreference)
    }
  }, [])

  const toggleTheme = () => {
    const nextTheme: ThemeMode = theme === 'dark' ? 'light' : 'dark'
    setTheme(nextTheme)
  }

  return (
    <header className="site-header">
      <div className="container nav-wrap">
        <Link to="/" className="brand" aria-label="Ir para a página inicial" onClick={() => setMenuOpen(false)}>
          {siteConfig.name}
        </Link>

        <div className="header-actions">
          <button
            type="button"
            className="theme-toggle"
            aria-label={theme === 'dark' ? 'Alternar para tema claro' : 'Alternar para tema escuro'}
            title={theme === 'dark' ? 'Alternar para tema claro' : 'Alternar para tema escuro'}
            onClick={toggleTheme}
          >
            {theme === 'dark' ? (
              <svg viewBox="0 0 24 24" aria-hidden="true">
                <path d="M12 2.75a.75.75 0 0 1 .75.75v1.5a.75.75 0 1 1-1.5 0V3.5a.75.75 0 0 1 .75-.75Zm0 15.5a.75.75 0 0 1 .75.75v1.5a.75.75 0 1 1-1.5 0v-1.5a.75.75 0 0 1 .75-.75ZM4.93 4.93a.75.75 0 0 1 1.06 0l1.06 1.06a.75.75 0 1 1-1.06 1.06L4.93 6a.75.75 0 0 1 0-1.06Zm11.01 11.01a.75.75 0 0 1 1.06 0l1.06 1.06a.75.75 0 0 1-1.06 1.06l-1.06-1.06a.75.75 0 0 1 0-1.06ZM2.75 12a.75.75 0 0 1 .75-.75h1.5a.75.75 0 0 1 0 1.5H3.5a.75.75 0 0 1-.75-.75Zm15.5 0a.75.75 0 0 1 .75-.75h1.5a.75.75 0 0 1 0 1.5h-1.5a.75.75 0 0 1-.75-.75ZM4.93 18.07a.75.75 0 0 1 0-1.06l1.06-1.06a.75.75 0 1 1 1.06 1.06L6 18.07a.75.75 0 0 1-1.06 0Zm11.01-11.01a.75.75 0 0 1 0-1.06l1.06-1.06a.75.75 0 0 1 1.06 1.06L17 6.99a.75.75 0 0 1-1.06 0ZM12 7.25A4.75 4.75 0 1 1 12 16.75 4.75 4.75 0 0 1 12 7.25Z" fill="currentColor"/>
              </svg>
            ) : (
              <svg viewBox="0 0 24 24" aria-hidden="true">
                <path d="M21 12.8A8.8 8.8 0 0 1 11.2 3a.75.75 0 0 0-.9.9A8.8 8.8 0 0 0 20.1 13.7a.75.75 0 0 0 .9-.9Zm-8.4-7.2a7.3 7.3 0 0 1 5.2 12.6A7.3 7.3 0 0 1 12.6 5.6Z" fill="currentColor"/>
              </svg>
            )}
            <span className="sr-only">{theme === 'dark' ? 'Tema claro' : 'Tema escuro'}</span>
          </button>

          <button
            type="button"
            className="menu-toggle"
            aria-expanded={menuOpen}
            aria-controls="primary-navigation"
            aria-label={menuOpen ? 'Fechar menu' : 'Abrir menu'}
            onClick={() => setMenuOpen((state) => !state)}
          >
            <span />
            <span />
            <span />
          </button>
        </div>

        <nav id="primary-navigation" className={`site-nav ${menuOpen ? 'open' : ''}`} aria-label="Navegação principal">
          {navItems.map((item) => (
            <Link key={item.href} to={item.href} onClick={() => setMenuOpen(false)}>
              {item.label}
            </Link>
          ))}
        </nav>
      </div>
    </header>
  )
}
