export type ProjectLinkStatus = 'available' | 'coming-soon' | 'private' | 'not-applicable'

export type ProjectLink = {
  url?: string
  status: ProjectLinkStatus
}

export type ProjectArchitecture = {
  overview: string
  frontend?: string[]
  backend?: string[]
  database?: string[]
  integrations?: string[]
  dataFlow?: string
  decisions?: {
    decision: string
    reason: string
  }[]
  structure?: {
    path: string
    purpose: string
  }[]
}

export type ProjectStatus = 'em desenvolvimento' | 'concluído' | 'planejado'

export type Project = {
  slug: string
  title: string
  summary: string
  description: string
  status: ProjectStatus
  technologies: string[]
  demo: ProjectLink
  github: ProjectLink
  architecture: ProjectArchitecture
  features?: string[]
  challenges?: string[]
  futureImprovements?: string[]
  image?: string
  period?: string
  featured?: boolean
}

export type Experience = {
  role: string
  company: string
  employmentType?: string
  startDate: string
  endDate?: string
  isCurrent?: boolean
  location?: string
  description: string
  responsibilities: string[]
  technologies?: string[]
  url?: string
}

export type Technology = {
  name: string
  category: 'Linguagens' | 'Front-end' | 'Back-end' | 'Banco de dados' | 'Ferramentas e ambiente'
  description?: string
  status?: 'estudando' | 'em uso' | 'explorando'
}

export type GitHubRepo = {
  name: string
  description: string
  technologies: string[]
  url?: string
}
