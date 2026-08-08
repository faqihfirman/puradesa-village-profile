import { Link } from '@inertiajs/react';
import { formatDate } from '@/lib/format';
import type { Article } from '@/types';

export default function ArticleCard({ article }: { article: Article }) {
  return (
    <Link
      href={`/artikel/${article.slug}`}
      className="group flex flex-col overflow-hidden rounded-card border border-border bg-surface transition-colors hover:border-secondary"
    >
      <div className="relative aspect-[16/9] w-full overflow-hidden bg-secondary-container">
        {article.coverUrl ? (
          <img src={article.coverUrl} alt={article.title} className="h-full w-full object-cover" loading="lazy" />
        ) : (
          <div className="flex h-full w-full items-center justify-center font-display text-sm text-secondary">
            Desa Puraseda
          </div>
        )}
        {article.category && (
          <span
            className="absolute left-3 top-3 rounded-badge px-2.5 py-1 font-display text-xs font-semibold text-white"
            style={{ backgroundColor: article.category.color }}
          >
            {article.category.name}
          </span>
        )}
      </div>
      <div className="flex flex-1 flex-col gap-2 p-5">
        {article.publishedAt && <span className="text-xs text-muted">{formatDate(article.publishedAt)}</span>}
        <h3 className="font-display text-lg font-semibold text-ink group-hover:text-primary">{article.title}</h3>
        <p className="line-clamp-2 text-sm text-body">{article.excerpt}</p>
        <span className="mt-auto pt-2 font-display text-sm font-semibold text-primary">Baca Selengkapnya →</span>
      </div>
    </Link>
  );
}
