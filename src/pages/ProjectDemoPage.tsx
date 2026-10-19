import { useMemo, useState } from 'react'
import { Link, useParams } from 'react-router-dom'
import { projects } from '../data/projects'

type DemoState = {
  stats: {
    revenue: number
    orders: number
    clients: number
    lowStock: number
  }
  clients: {
    id: number
    name: string
    company: string
    email: string
    status: 'Ativo' | 'Inativo'
  }[]
  products: {
    id: number
    sku: string
    name: string
    category: string
    stock: number
    minStock: number
    price: number
  }[]
  sales: {
    id: number
    client: string
    status: 'Pago' | 'Pendente' | 'Cancelado'
    total: number
    date: string
  }[]
}

const demoState: DemoState = {
  stats: {
    revenue: 98450,
    orders: 128,
    clients: 42,
    lowStock: 4,
  },
  clients: [
    { id: 1, name: 'Ana Souza', company: 'Natura Atelier', email: 'ana@naturaatelier.com', status: 'Ativo' },
    { id: 2, name: 'Bruno Costa', company: 'Lojas Nova', email: 'bruno@lojasnova.com', status: 'Ativo' },
    { id: 3, name: 'Carla Mendes', company: 'Mendes Distribuição', email: 'carla@mendesdist.com', status: 'Inativo' },
  ],
  products: [
    { id: 1, sku: 'ERP-001', name: 'Kit de Escritório', category: 'Material', stock: 18, minStock: 8, price: 240 },
    { id: 2, sku: 'ERP-025', name: 'Monitor 27', category: 'Tecnologia', stock: 6, minStock: 8, price: 1380 },
    { id: 3, sku: 'ERP-041', name: 'Cadeira Ergonomica', category: 'Mobiliário', stock: 12, minStock: 5, price: 920 },
  ],
  sales: [
    { id: 101, client: 'Ana Souza', status: 'Pago', total: 1840, date: '2026-10-15' },
    { id: 102, client: 'Bruno Costa', status: 'Pendente', total: 3650, date: '2026-10-12' },
    { id: 103, client: 'Carla Mendes', status: 'Cancelado', total: 850, date: '2026-10-05' },
  ],
}

function ProjectDemoPage() {
  const { slug } = useParams()
  const project = projects.find((item) => item.slug === slug)
  const [activeTab, setActiveTab] = useState<'dashboard' | 'clientes' | 'produtos' | 'vendas'>('dashboard')

  const currency = useMemo(
    () =>
      new Intl.NumberFormat('pt-BR', {
        style: 'currency',
        currency: 'BRL',
      }),
    [],
  )

  if (!project) {
    return (
      <main className="page-shell">
        <div className="container narrow">
          <div className="detail-empty">
            <p className="eyebrow">Demo</p>
            <h1>Projeto não encontrado</h1>
            <Link to="/" className="button button-primary">
              Voltar para a home
            </Link>
          </div>
        </div>
      </main>
    )
  }

  return (
    <main className="page-shell">
      <div className="container demo-shell">
        <div className="demo-header">
          <div>
            <p className="eyebrow">Demo</p>
            <h1>{project.title}</h1>
          </div>
          <div className="demo-actions">
            <Link to={`/projetos/${project.slug}`} className="button button-secondary">
              Voltar ao projeto
            </Link>
          </div>
        </div>

        <div className="demo-banner" role="status" aria-live="polite">
          Modo demonstração — somente leitura. Os dados abaixo são fictícios e não podem ser alterados.
        </div>

        <nav className="demo-tabs" aria-label="Navegação da demonstração">
          {['dashboard', 'clientes', 'produtos', 'vendas'].map((tab) => (
            <button
              key={tab}
              type="button"
              className={activeTab === tab ? 'demo-tab active' : 'demo-tab'}
              onClick={() => setActiveTab(tab as typeof activeTab)}
            >
              {tab === 'dashboard' && 'Dashboard'}
              {tab === 'clientes' && 'Clientes'}
              {tab === 'produtos' && 'Produtos'}
              {tab === 'vendas' && 'Vendas'}
            </button>
          ))}
        </nav>

        {activeTab === 'dashboard' ? (
          <div className="demo-grid">
            <div className="demo-stat">
              <span>Faturamento</span>
              <strong>{currency.format(demoState.stats.revenue)}</strong>
            </div>
            <div className="demo-stat">
              <span>Pedidos</span>
              <strong>{demoState.stats.orders}</strong>
            </div>
            <div className="demo-stat">
              <span>Clientes ativos</span>
              <strong>{demoState.stats.clients}</strong>
            </div>
            <div className="demo-stat warning">
              <span>Estoque baixo</span>
              <strong>{demoState.stats.lowStock}</strong>
            </div>
          </div>
        ) : null}

        {activeTab === 'clientes' ? (
          <div className="demo-table-wrap">
            <table className="demo-table">
              <thead>
                <tr>
                  <th>Cliente</th>
                  <th>Empresa</th>
                  <th>E-mail</th>
                  <th>Status</th>
                </tr>
              </thead>
              <tbody>
                {demoState.clients.map((client) => (
                  <tr key={client.id}>
                    <td>{client.name}</td>
                    <td>{client.company}</td>
                    <td>{client.email}</td>
                    <td>{client.status}</td>
                  </tr>
                ))}
              </tbody>
            </table>
          </div>
        ) : null}

        {activeTab === 'produtos' ? (
          <div className="demo-table-wrap">
            <table className="demo-table">
              <thead>
                <tr>
                  <th>SKU</th>
                  <th>Produto</th>
                  <th>Categoria</th>
                  <th>Estoque</th>
                  <th>Preço</th>
                </tr>
              </thead>
              <tbody>
                {demoState.products.map((product) => (
                  <tr key={product.id}>
                    <td>{product.sku}</td>
                    <td>{product.name}</td>
                    <td>{product.category}</td>
                    <td>{product.stock} / {product.minStock}</td>
                    <td>{currency.format(product.price)}</td>
                  </tr>
                ))}
              </tbody>
            </table>
          </div>
        ) : null}

        {activeTab === 'vendas' ? (
          <div className="demo-table-wrap">
            <table className="demo-table">
              <thead>
                <tr>
                  <th>Pedido</th>
                  <th>Cliente</th>
                  <th>Status</th>
                  <th>Total</th>
                  <th>Data</th>
                </tr>
              </thead>
              <tbody>
                {demoState.sales.map((sale) => (
                  <tr key={sale.id}>
                    <td>#{sale.id}</td>
                    <td>{sale.client}</td>
                    <td>{sale.status}</td>
                    <td>{currency.format(sale.total)}</td>
                    <td>{sale.date}</td>
                  </tr>
                ))}
              </tbody>
            </table>
          </div>
        ) : null}
      </div>
    </main>
  )
}

export default ProjectDemoPage
