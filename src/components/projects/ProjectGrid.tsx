import { ProjectCard } from './ProjectCard'
import type { Project } from '../../types/project'

type ProjectGridProps = {
  projects: Project[]
}

export function ProjectGrid({ projects }: ProjectGridProps) {
  if (projects.length === 0) {
    return <p className="empty-state">Os projetos serão adicionados conforme forem documentados.</p>
  }

  return (
    <div className="project-grid">
      {projects.map((project) => (
        <ProjectCard key={project.slug} project={project} />
      ))}
    </div>
  )
}
