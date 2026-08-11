import { Head, Link } from '@inertiajs/react';
import { Calendar, User } from 'lucide-react';
import ArticleCard from '@/Components/ArticleCard';
import CategoryFilterPills from '@/Components/CategoryFilterPills';
import Pagination from '@/Components/Pagination';
import PublicLayout from '@/Layouts/PublicLayout';
import { formatDate } from '@/lib/format';
import type { ArticlesIndexProps } from '@/types';

export default function ArticlesIndex({ featured, categories, activeCategory, articles }: ArticlesIndexProps) {
  return (
    <PublicLayout>
      <Head title="Artikel" />

      <div className="bg-background-alt pb-section-mobile pt-10 md:pb-section-desktop md:pt-14">
        <div className="mx-auto max-w-container px-4 md:px-6 ">
          <div className="mx-auto max-w-2xl text-center py-8">
            <h1 className="font-display text-3xl font-bold text-ink md:text-5xl">Kabar Desa Terkini</h1>
            <p className="mt-4 text-body">
              Ikuti perkembangan terbaru, program kerja, dan pengumuman resmi dari Pemerintah Desa. Transparansi dan
              informasi untuk seluruh masyarakat.
            </p>
          </div>

          {featured && (
            <Link
              href={`/artikel/${featured.slug}`}
              className="group relative mt-10 flex min-h-[420px] items-end overflow-hidden rounded-card"
            >
              {featured.coverUrl ? (
                <>
                  <img
                    src={featured.coverUrl}
                    alt={featured.title}
                    className="absolute inset-0 h-full w-full object-cover transition-transform group-hover:scale-105"
                    loading="eager"
                  />
                  <div className="absolute inset-0 bg-gradient-to-t from-ink/90 via-ink/30 to-transparent" />
                </>
              ) : (
                <div className="absolute inset-0 bg-gradient-to-br from-primary to-primary-hover" />
              )}

              <div className="relative flex flex-col gap-3 p-6 md:p-10">
                {featured.category && (
                  <span className="w-fit rounded-badge bg-accent px-2.5 py-1 font-display text-xs font-semibold uppercase tracking-wider text-on-accent">
                    {featured.category.name}
                  </span>
                )}
                <h2 className="max-w-2xl font-display text-2xl font-bold text-white md:text-4xl">{featured.title}</h2>
                <div className="flex flex-wrap items-center gap-4 text-sm text-white">
                  {featured.publishedAt && (
                    <span className="flex items-center gap-1.5">
                      <Calendar className="h-4 w-4" /> {formatDate(featured.publishedAt)}
                    </span>
                  )}
                  <span className="flex items-center gap-1.5">
                    <User className="h-4 w-4" /> {featured.authorName}
                  </span>
                </div>
              </div>
            </Link>
          )}

          <div className="mt-12 flex flex-col justify-between gap-4 md:flex-row md:items-center">
            <h2 className="font-display text-2xl font-semibold text-ink">Semua Berita</h2>
            <CategoryFilterPills categories={categories} active={activeCategory} />
          </div>

          {articles.data.length > 0 ? (
            <div className="mt-8 grid gap-6 md:grid-cols-3">
              {articles.data.map((article) => (
                <ArticleCard key={article.slug} article={article} />
              ))}
            </div>
          ) : (
            <p className="mt-8 text-center text-muted">Belum ada artikel untuk kategori ini.</p>
          )}

          <Pagination links={articles.links} />
        </div>
      </div>
    </PublicLayout>
  );
}
