import type { ProjectLink } from '../../types/project'

type ProjectLinksProps = {
  demo: ProjectLink
  github: ProjectLink
}

export function ProjectLinks({ demo, github }: ProjectLinksProps) {
  return (
    <div className="project-links">
      {demo.status === 'available' && demo.url ? (
        <a href={demo.url} target="_blank" rel="noopener noreferrer">Abrir demo</a>
      ) : (
        <span className="muted-link">Demo em desenvolvimento</span>
      )}

      {github.status === 'available' && github.url ? (
        <a href={github.url} target="_blank" rel="noopener noreferrer">Ver repositório</a>
      ) : github.status === 'private' ? (
        <span className="muted-link">Repositório privado</span>
      ) : (
        <span className="muted-link">GitHub em breve</span>
      )}
    </div>
  )
}
