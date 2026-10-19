import { Link, useParams } from 'react-router-dom'
import { ProjectLinks } from '../components/projects/ProjectLinks'
import { projects } from '../data/projects'

function ProjectDetailsPage() {
  const { slug } = useParams()
  const project = projects.find((item) => item.slug === slug)

  if (!project) {
    return (
      <main className="page-shell">
        <div className="container narrow">
          <div className="detail-empty">
            <p className="eyebrow">Projeto</p>
            <h1>Projeto não encontrado</h1>
            <p>Este registro ainda não foi criado ou o link informado não corresponde a um projeto ativo.</p>
            <Link to="/" className="button button-primary">
              Voltar para a home
            </Link>
          </div>
        </div>
      </main>
    )
  }

  const architectureSections = [
    { title: 'Frontend', items: project.architecture.frontend },
    { title: 'Backend', items: project.architecture.backend },
    { title: 'Banco de dados', items: project.architecture.database },
    { title: 'Integrações', items: project.architecture.integrations },
  ].filter((section) => section.items && section.items.length > 0)

  return (
    <main className="page-shell">
      <div className="container details-container">
        <div className="detail-topbar">
          <Link to="/#projetos" className="text-link">
            ← Voltar para Projetos
          </Link>
        </div>

        <header className="detail-header">
          <div>
            <p className="eyebrow">{project.status}</p>
            <h1>{project.title}</h1>
            <p className="detail-summary">{project.summary}</p>
          </div>
          <ProjectLinks demo={project.demo} github={project.github} />
        </header>

        <section className="detail-section">
          <h2>Descrição</h2>
          <p>{project.description}</p>
        </section>

        {project.features && project.features.length > 0 ? (
          <section className="detail-section">
            <h2>Funcionalidades principais</h2>
            <ul className="detail-list">
              {project.features.map((feature) => (
                <li key={feature}>{feature}</li>
              ))}
            </ul>
          </section>
        ) : null}

        {project.challenges && project.challenges.length > 0 ? (
          <section className="detail-section">
            <h2>Desafios e decisões</h2>
            <ul className="detail-list">
              {project.challenges.map((challenge) => (
                <li key={challenge}>{challenge}</li>
              ))}
            </ul>
          </section>
        ) : null}

        <section className="detail-section">
          <h2>Tecnologias</h2>
          <div className="chip-row">
            {project.technologies.map((technology) => (
              <span key={technology} className="chip">
                {technology}
              </span>
            ))}
          </div>
        </section>

        <section className="detail-section">
          <h2>Arquitetura</h2>
          <p>{project.architecture.overview}</p>
          {project.architecture.dataFlow ? <p className="detail-note">Fluxo de dados: {project.architecture.dataFlow}</p> : null}

          {architectureSections.length > 0 ? (
            <div className="architecture-grid">
              {architectureSections.map((section) => (
                <div key={section.title} className="architecture-card">
                  <h3>{section.title}</h3>
                  <ul>
                    {section.items?.map((item) => (
                      <li key={item}>{item}</li>
                    ))}
                  </ul>
                </div>
              ))}
            </div>
          ) : null}

          {project.architecture.decisions && project.architecture.decisions.length > 0 ? (
            <div className="decision-list">
              {project.architecture.decisions.map((decision) => (
                <div key={decision.decision} className="decision-item">
                  <h3>{decision.decision}</h3>
                  <p>{decision.reason}</p>
                </div>
              ))}
            </div>
          ) : null}

          {project.architecture.structure && project.architecture.structure.length > 0 ? (
            <div className="structure-list">
              <h3>Estrutura relevante</h3>
              <ul>
                {project.architecture.structure.map((item) => (
                  <li key={item.path}>
                    <strong>{item.path}</strong> — {item.purpose}
                  </li>
                ))}
              </ul>
            </div>
          ) : null}
        </section>

        {project.futureImprovements && project.futureImprovements.length > 0 ? (
          <section className="detail-section">
            <h2>Melhorias futuras</h2>
            <ul className="detail-list">
              {project.futureImprovements.map((item) => (
                <li key={item}>{item}</li>
              ))}
            </ul>
          </section>
        ) : null}

        {project.period ? (
          <section className="detail-section small-meta">
            <h2>Período</h2>
            <p>{project.period}</p>
          </section>
        ) : null}
      </div>
    </main>
  )
}

export default ProjectDetailsPage
