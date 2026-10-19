import { siteConfig } from '../../data/site'

const year = new Date().getFullYear()

export function Footer() {
  const socialLinks = [
    {
      label: 'GitHub',
      href: siteConfig.githubUrl || undefined,
      icon: (
        <svg viewBox="0 0 24 24" aria-hidden="true">
          <path d="M12 .5C5.65.5.5 5.65.5 12c0 5.08 3.29 9.37 7.86 10.88.58.1.79-.25.79-.56v-2.13c-3.2.7-3.87-1.53-3.87-1.53-.52-1.33-1.28-1.68-1.28-1.68-1.05-.72.08-.7.08-.7 1.16.08 1.77 1.2 1.77 1.2 1.03 1.77 2.7 1.26 3.35.96.1-.75.4-1.26.73-1.55-2.56-.29-5.25-1.28-5.25-5.69 0-1.26.45-2.29 1.18-3.09-.12-.29-.51-1.45.11-3.02 0 0 .97-.31 3.18 1.18a11.02 11.02 0 0 1 5.8 0c2.2-1.49 3.17-1.18 3.17-1.18.63 1.57.24 2.73.12 3.02.74.8 1.18 1.83 1.18 3.09 0 4.42-2.7 5.39-5.27 5.67.42.36.8 1.06.8 2.14v3.18c0 .31.21.67.8.56A11.51 11.51 0 0 0 23.5 12C23.5 5.65 18.35.5 12 .5Z" fill="currentColor"/>
        </svg>
      ),
    },
    {
      label: 'LinkedIn',
      href: siteConfig.linkedinUrl || undefined,
      icon: (
        <svg viewBox="0 0 24 24" aria-hidden="true">
          <path d="M6.94 8.5A2.56 2.56 0 1 1 6.93 3.4a2.56 2.56 0 0 1 .01 5.1Zm-2.17 1.9h4.35v9.6H4.77v-9.6Zm7.08 0h4.17v1.31h.06c.58-1.1 2-2.25 4.12-2.25 4.41 0 5.22 2.9 5.22 6.67v4.87h-4.35v-4.57c0-1.09-.02-2.5-1.53-2.5-1.53 0-1.77 1.19-1.77 2.42v4.66h-4.35v-9.6Z" fill="currentColor"/>
        </svg>
      ),
    },
  ].filter((link): link is { label: string; href: string; icon: React.ReactNode } => Boolean(link.href))

  return (
    <footer className="site-footer">
      <div className="container footer-inner">
        <div className="footer-brand">
          <span className="footer-brand__label">Levi Cavadas</span>
          <span className="footer-brand__meta">Desenvolvimento de software</span>
        </div>

        <nav aria-label="Navegação do rodapé" className="footer-nav">
          <a href="/#inicio">Home</a>
          <a href="/#projetos">Projetos</a>
          <a href="/#tecnologias">Tecnologias</a>
          <a href="/#contato">Contato</a>
        </nav>

        <div className="footer-contact">
          {siteConfig.email ? (
            <a href={`mailto:${siteConfig.email}`}>{siteConfig.email}</a>
          ) : (
            <span>Contato em breve</span>
          )}
        </div>

        <div className="footer-socials">
          {socialLinks.length > 0 ? (
            socialLinks.map((link) => (
              <a key={link.label} href={link.href} target="_blank" rel="noopener noreferrer" aria-label={link.label} className="social-link social-link--footer">
                <span className="social-link__icon" aria-hidden="true">{link.icon}</span>
                <span className="social-link__label">{link.label}</span>
              </a>
            ))
          ) : (
            <span>Links em breve</span>
          )}
        </div>
      </div>

      <div className="container footer-bottom">
        <span>© {year} {siteConfig.name}</span>
      </div>
    </footer>
  )
}
