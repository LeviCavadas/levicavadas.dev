import { Header } from '../components/layout/Header'
import { Footer } from '../components/layout/Footer'
import { SectionHeading } from '../components/layout/SectionHeading'
import { ProjectGrid } from '../components/projects/ProjectGrid'
import { technologies } from '../data/technologies'
import { highlightedRepos } from '../data/github'
import { projects } from '../data/projects'
import { experiences } from '../data/experience'
import { siteConfig } from '../data/site'

const navSections = ['Linguagens', 'Front-end', 'Back-end', 'Banco de dados', 'Ferramentas e ambiente']

type SocialLinkProps = {
  href: string
  label: string
  icon: 'github' | 'linkedin'
  className?: string
}

function SocialLink({ href, label, icon, className = '' }: SocialLinkProps) {
  const iconMarkup = icon === 'github'
    ? (
        <svg viewBox="0 0 24 24" aria-hidden="true">
          <path d="M12 .5C5.65.5.5 5.65.5 12c0 5.08 3.29 9.37 7.86 10.88.58.1.79-.25.79-.56v-2.13c-3.2.7-3.87-1.53-3.87-1.53-.52-1.33-1.28-1.68-1.28-1.68-1.05-.72.08-.7.08-.7 1.16.08 1.77 1.2 1.77 1.2 1.03 1.77 2.7 1.26 3.35.96.1-.75.4-1.26.73-1.55-2.56-.29-5.25-1.28-5.25-5.69 0-1.26.45-2.29 1.18-3.09-.12-.29-.51-1.45.11-3.02 0 0 .97-.31 3.18 1.18a11.02 11.02 0 0 1 5.8 0c2.2-1.49 3.17-1.18 3.17-1.18.63 1.57.24 2.73.12 3.02.74.8 1.18 1.83 1.18 3.09 0 4.42-2.7 5.39-5.27 5.67.42.36.8 1.06.8 2.14v3.18c0 .31.21.67.8.56A11.51 11.51 0 0 0 23.5 12C23.5 5.65 18.35.5 12 .5Z" fill="currentColor"/>
        </svg>
      )
    : (
        <svg viewBox="0 0 24 24" aria-hidden="true">
          <path d="M6.94 8.5A2.56 2.56 0 1 1 6.93 3.4a2.56 2.56 0 0 1 .01 5.1Zm-2.17 1.9h4.35v9.6H4.77v-9.6Zm7.08 0h4.17v1.31h.06c.58-1.1 2-2.25 4.12-2.25 4.41 0 5.22 2.9 5.22 6.67v4.87h-4.35v-4.57c0-1.09-.02-2.5-1.53-2.5-1.53 0-1.77 1.19-1.77 2.42v4.66h-4.35v-9.6Z" fill="currentColor"/>
        </svg>
      )

  return (
    <a href={href} target="_blank" rel="noopener noreferrer" aria-label={label} className={`social-link ${className}`.trim()}>
      <span className="social-link__icon" aria-hidden="true">{iconMarkup}</span>
      <span className="social-link__label">{label}</span>
    </a>
  )
}

function HomePage() {
  const groupedTechnologies = navSections
    .map((category) => ({
      category,
      items: technologies.filter((technology) => technology.category === category),
    }))
    .filter((group) => group.items.length > 0)

  const email = siteConfig.email?.trim()
  const githubUrl = siteConfig.githubUrl?.trim()
  const linkedinUrl = siteConfig.linkedinUrl?.trim()

  return (
    <>
      <Header />
      <main>
        <section id="inicio" className="hero-section">
          <div className="container hero-grid">
            <div className="hero-copy">
              <p className="eyebrow">{siteConfig.role}</p>
              <h1>{siteConfig.name}</h1>
              <p className="hero-text">{siteConfig.heroDescription}</p>
              <div className="hero-actions">
                <a href="#projetos" className="button button-primary">
                  Ver projetos
                </a>
                <a href="#contato" className="button button-secondary">
                  Falar por e-mail
                </a>
              </div>
              <div className="hero-socials">
                {githubUrl ? <SocialLink href={githubUrl} label="GitHub" icon="github" /> : null}
                {linkedinUrl ? <SocialLink href={linkedinUrl} label="LinkedIn" icon="linkedin" /> : null}
                {!githubUrl && !linkedinUrl ? <span className="muted-link">Links sociais em breve</span> : null}
              </div>
            </div>

            <div className="hero-visual" aria-label="Ilustração de desenvolvimento de software">
              <div className="window-card">
                <div className="window-topbar">
                  <span />
                  <span />
                  <span />
                </div>
                <div className="window-body">
                  <div className="code-block">
                    <span className="token keyword">const</span> {`portfolio`}{' = '}<span className="token string">'Levi Cavadas'</span>;
                  </div>
                  <div className="code-block">
                    <span className="token keyword">function</span> <span className="token function">foco</span>() {'{'}
                  </div>
                  <div className="code-block indent">
                    <span className="token keyword">return</span> <span className="token string">'clareza + utilidade + código útil'</span>;
                  </div>
                  <div className="code-block">{' }'}</div>
                </div>
              </div>
            </div>
          </div>
        </section>

        <section id="sobre" className="content-section">
          <div className="container narrow">
            <SectionHeading
              eyebrow="Sobre"
              title="Construo software com foco em clareza, manutenção e uso real."
              description="Trabalho em projetos que precisam ser simples de entender, fáceis de manter e úteis no dia a dia."
            />
            <div className="about-card">
              <p>{siteConfig.about}</p>
            </div>
          </div>
        </section>

        <section id="experiencia" className="content-section alt-section">
          <div className="container">
            <SectionHeading
              eyebrow="Experiência"
              title="Contextos e aprendizados relevantes"
              description="Este espaço reúne os projetos, os desafios e as áreas em que venho trabalhando e aprendendo ao longo do tempo."
            />

            {experiences.length > 0 ? (
              <div className="timeline">
                {experiences.map((experience) => (
                  <article key={`${experience.company}-${experience.role}`} className="timeline-item">
                    <div className="timeline-marker" aria-hidden="true" />
                    <div className="timeline-content">
                      <div className="timeline-header">
                        <div>
                          <h3>{experience.role}</h3>
                          <p>
                            {experience.company}
                            {experience.location ? ` · ${experience.location}` : ''}
                          </p>
                        </div>
                        <span>
                          {experience.startDate} — {experience.isCurrent ? 'Atual' : experience.endDate || 'Até o momento'}
                        </span>
                      </div>
                      {experience.description ? <p>{experience.description}</p> : null}
                      {experience.responsibilities.length > 0 ? (
                        <ul>
                          {experience.responsibilities.map((responsibility) => (
                            <li key={responsibility}>{responsibility}</li>
                          ))}
                        </ul>
                      ) : null}
                      {experience.technologies && experience.technologies.length > 0 ? (
                        <div className="chip-row">
                          {experience.technologies.map((technology) => (
                            <span key={technology} className="chip">
                              {technology}
                            </span>
                          ))}
                        </div>
                      ) : null}
                    </div>
                  </article>
                ))}
              </div>
            ) : (
              <div className="empty-state">Ainda estou organizando experiências e projetos relevantes para apresentar aqui com mais contexto e clareza.</div>
            )}
          </div>
        </section>

        <section id="projetos" className="content-section">
          <div className="container">
            <SectionHeading
              eyebrow="Projetos"
              title="Projetos, estudos e ferramentas em desenvolvimento"
              description="Aqui estão alguns trabalhos que refletem o tipo de problema em que tenho me interessado e a forma como estou tentando resolvê-los."
            />
            <ProjectGrid projects={projects} />
          </div>
        </section>

        <section id="tecnologias" className="content-section alt-section">
          <div className="container">
            <SectionHeading
              eyebrow="Tecnologias"
              title="Ferramentas e áreas em que trabalho"
              description="A lista reúne as tecnologias que venho usando, explorando e aplicando em projetos reais e em estudo."
            />
            <div className="technology-grid">
              {groupedTechnologies.map((group) => (
                <div key={group.category} className="technology-group">
                  <h3>{group.category}</h3>
                  <ul>
                    {group.items.map((technology) => (
                      <li key={technology.name}>
                        <div>
                          <strong>{technology.name}</strong>
                          {technology.description ? <span>{technology.description}</span> : null}
                        </div>
                        {technology.status ? <em>{technology.status}</em> : null}
                      </li>
                    ))}
                  </ul>
                </div>
              ))}
            </div>
          </div>
        </section>

        <section id="github" className="content-section">
          <div className="container narrow">
            <SectionHeading
              eyebrow="GitHub"
              title="Projetos e código compartilhado"
              description="Aqui ficam os materiais que posso publicar publicamente e os projetos que estão abertos para consulta e acompanhamento."
            />

            {highlightedRepos.length > 0 ? (
              <div className="repo-grid">
                {highlightedRepos.map((repo) => (
                  <article key={repo.name} className="repo-card">
                    <h3>{repo.name}</h3>
                    <p>{repo.description}</p>
                    {repo.technologies.length > 0 ? (
                      <div className="chip-row">
                        {repo.technologies.map((technology) => (
                          <span key={`${repo.name}-${technology}`} className="chip">
                            {technology}
                          </span>
                        ))}
                      </div>
                    ) : null}
                    {repo.url ? (
                      <a href={repo.url} target="_blank" rel="noopener noreferrer" className="text-link">
                        Ver repositório
                      </a>
                    ) : (
                      <span className="muted-link">Link em breve</span>
                    )}
                  </article>
                ))}
              </div>
            ) : (
              <div className="empty-state">Ainda não há repositórios destacados para divulgar neste espaço, mas o perfil público continua disponível quando necessário.</div>
            )}

            {githubUrl ? (
              <div className="cta-block">
                <p>Perfil público no GitHub:</p>
                <a href={githubUrl} target="_blank" rel="noopener noreferrer" className="button button-primary">
                  Abrir perfil
                </a>
              </div>
            ) : (
              <div className="empty-state">O perfil do GitHub será incluído quando estiver pronto.</div>
            )}
          </div>
        </section>

        <section id="linkedin" className="content-section alt-section">
          <div className="container narrow">
            <SectionHeading
              eyebrow="LinkedIn"
              title="Perfil profissional"
              description="Aqui está meu perfil profissional para conectar com oportunidades, colaborações e conversas mais técnicas."
            />
            {linkedinUrl ? (
              <div className="cta-block">
                <p>Conecte-se profissionalmente e acompanhe atualizações relevantes.</p>
                <a href={linkedinUrl} target="_blank" rel="noopener noreferrer" className="button button-primary">
                  Visitar LinkedIn
                </a>
              </div>
            ) : (
              <div className="empty-state">O perfil do LinkedIn será incluído quando estiver disponível.</div>
            )}
          </div>
        </section>

        <section id="contato" className="content-section">
          <div className="container narrow">
            <SectionHeading
              eyebrow="Contato"
              title="Vamos conversar"
              description="Se quiser discutir um projeto, trocar ideias ou falar sobre desenvolvimento, pode entrar em contato por aqui."
            />
            <div className="contact-grid">
              {email ? (
                <a href={`mailto:${email}`} className="contact-card">
                  <span className="mini-label">E-mail</span>
                  <strong>{email}</strong>
                </a>
              ) : (
                <div className="contact-card disabled">
                  <span className="mini-label">E-mail</span>
                  <strong>E-mail em breve</strong>
                </div>
              )}

              {linkedinUrl ? (
                <a href={linkedinUrl} target="_blank" rel="noopener noreferrer" className="contact-card">
                  <span className="mini-label">LinkedIn</span>
                  <strong>Perfil profissional</strong>
                </a>
              ) : (
                <div className="contact-card disabled">
                  <span className="mini-label">LinkedIn</span>
                  <strong>Perfil em breve</strong>
                </div>
              )}

              {githubUrl ? (
                <a href={githubUrl} target="_blank" rel="noopener noreferrer" className="contact-card">
                  <span className="mini-label">GitHub</span>
                  <strong>Repositórios</strong>
                </a>
              ) : (
                <div className="contact-card disabled">
                  <span className="mini-label">GitHub</span>
                  <strong>Perfil em breve</strong>
                </div>
              )}
            </div>
          </div>
        </section>
      </main>
      <Footer />
    </>
  )
}

export default HomePage
