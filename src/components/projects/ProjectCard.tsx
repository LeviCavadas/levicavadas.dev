import type { Project } from '../../types/project'

type ProjectCardProps = {
  project: Project
}

export function ProjectCard({ project }: ProjectCardProps) {
  const demoUrl = project.demo?.url && project.demo.status === 'available' ? project.demo.url : undefined
  const githubUrl = project.github?.url && project.github.status === 'available' ? project.github.url : undefined

  return (
    <article className="project-card">
      <div className="project-card__header">
        <span className="project-status">{project.status}</span>
        {project.featured ? <span className="project-featured">Destaque</span> : null}
      </div>
      <h3>{project.title}</h3>
      <p className="project-summary">{project.summary}</p>
      <ul className="project-technologies">
        {project.technologies.slice(0, 4).map((technology) => (
          <li key={technology}>{technology}</li>
        ))}
      </ul>
      <div className="project-actions">
        {demoUrl ? (
          <a href={demoUrl} target="_blank" rel="noopener noreferrer">Demo</a>
        ) : (
          <span className="muted-link">Demo em desenvolvimento</span>
        )}
        {githubUrl ? (
          <a href={githubUrl} target="_blank" rel="noopener noreferrer">GitHub</a>
        ) : (
          <span className="muted-link">GitHub privado</span>
        )}
        <a href={`/projetos/${project.slug}`}>Detalhes</a>
      </div>
    </article>
  )
}
