import { Head, Link } from '@inertiajs/react';
import { Calendar, Check, Copy, User } from 'lucide-react';
import { useState } from 'react';
import ArticleCard from '@/Components/ArticleCard';
import { FacebookIcon } from '@/Components/SocialIcons';
import PublicLayout from '@/Layouts/PublicLayout';
import { formatDate } from '@/lib/format';
import type { ArticleShowProps } from '@/types';

export default function ArticleShow({ article, related }: ArticleShowProps) {
  const [copied, setCopied] = useState(false);

  const shareUrl = typeof window !== 'undefined' ? window.location.href : '';
  const whatsappUrl = `https://wa.me/?text=${encodeURIComponent(`${article.title} — ${shareUrl}`)}`;
  const facebookUrl = `https://www.facebook.com/sharer/sharer.php?u=${encodeURIComponent(shareUrl)}`;

  const copyLink = async () => {
    await navigator.clipboard.writeText(shareUrl);
    setCopied(true);
    setTimeout(() => setCopied(false), 2000);
  };

  return (
    <PublicLayout>
      <Head title={article.title} />

      <article className="bg-background-alt pb-section-mobile pt-10 md:pb-section-desktop md:pt-14">
        <div className="mx-auto max-w-container px-4 md:px-6">
          <nav className="flex flex-wrap items-center gap-1.5 text-sm text-muted">
            <Link href="/" className="hover:text-primary">Beranda</Link>
            <span>›</span>
            <Link href="/artikel" className="hover:text-primary">Artikel</Link>
            <span>›</span>
            <span className="text-body">{article.title}</span>
          </nav>

          <div className="mx-auto max-w-3xl">
            {article.coverUrl && (
              <div className="relative mt-6 max-h-[480px] w-full overflow-hidden rounded-card">
                <img src={article.coverUrl} alt={article.title} className="h-full max-h-[480px] w-full object-cover" loading="eager" />
                {article.category && (
                  <span
                    className="absolute left-4 top-4 rounded-badge px-2.5 py-1 font-display text-xs font-semibold text-white"
                    style={{ backgroundColor: article.category.color }}
                  >
                    {article.category.name}
                  </span>
                )}
              </div>
            )}

            <h1 className="mt-6 font-display text-3xl font-bold text-ink md:text-4xl">{article.title}</h1>

            <div className="mt-4 flex flex-wrap items-center gap-4 text-sm text-muted">
              {article.publishedAt && (
                <span className="flex items-center gap-1.5">
                  <Calendar className="h-4 w-4" /> {formatDate(article.publishedAt)}
                </span>
              )}
              <span className="flex items-center gap-1.5">
                <User className="h-4 w-4" /> {article.authorName}
              </span>
            </div>

            <div className="article-body mt-8" dangerouslySetInnerHTML={{ __html: article.content }} />

            <div className="mt-10 flex items-center gap-3 border-t border-border pt-6">
              <span className="font-display text-sm font-semibold text-ink">Bagikan:</span>
              <a
                href={whatsappUrl}
                target="_blank"
                rel="noreferrer"
                className="flex h-10 w-10 items-center justify-center rounded-full bg-secondary-container text-on-secondary-container hover:bg-secondary hover:text-on-secondary"
                aria-label="Bagikan ke WhatsApp"
              >
              <svg viewBox="0 0 24 24" className="h-5 w-5" fill="currentColor" aria-hidden="true">
                <path d="M17.5 14.4c-.3-.1-1.6-.8-1.9-.9-.2-.1-.4-.1-.6.1-.2.3-.7.9-.8 1-.1.2-.3.2-.6.1-.3-.1-1.2-.5-2.3-1.5-.9-.8-1.4-1.7-1.6-2-.1-.3 0-.4.1-.6.1-.1.3-.3.4-.5.1-.1.2-.3.2-.4.1-.2 0-.4 0-.5-.1-.1-.6-1.5-.8-2-.2-.5-.4-.5-.6-.5h-.5c-.2 0-.5.1-.7.3-.2.3-.9 1-.9 2.3 0 1.3 1 2.6 1.1 2.8.1.2 2 3.1 4.9 4.3.7.3 1.2.5 1.6.6.7.2 1.3.2 1.8.1.5-.1 1.6-.7 1.9-1.3.2-.6.2-1.1.2-1.3-.1-.1-.3-.2-.5-.3z" />
                <path d="M12 2C6.5 2 2 6.5 2 12c0 1.9.5 3.6 1.4 5.1L2 22l5-1.3c1.4.8 3.1 1.2 4.9 1.2 5.5 0 10-4.5 10-10S17.5 2 12 2zm0 18.1c-1.6 0-3.1-.4-4.4-1.2l-.3-.2-3 .8.8-2.9-.2-.3C4.1 15 3.6 13.5 3.6 12c0-4.6 3.8-8.4 8.4-8.4s8.4 3.8 8.4 8.4-3.8 8.1-8.4 8.1z" />
              </svg>
            </a>
            <a
              href={facebookUrl}
              target="_blank"
              rel="noreferrer"
              className="flex h-10 w-10 items-center justify-center rounded-full bg-secondary-container text-on-secondary-container hover:bg-secondary hover:text-on-secondary"
              aria-label="Bagikan ke Facebook"
            >
              <FacebookIcon className="h-5 w-5" />
            </a>
            <button
              type="button"
              onClick={copyLink}
              className="flex h-10 w-10 items-center justify-center rounded-full bg-secondary-container text-on-secondary-container hover:bg-secondary hover:text-on-secondary"
              aria-label="Salin tautan"
            >
              {copied ? <Check className="h-5 w-5" /> : <Copy className="h-5 w-5" />}
            </button>
            </div>
          </div>
        </div>
      </article>

      {related.length > 0 && (
        <section className="bg-background py-section-mobile md:py-section-desktop">
          <div className="mx-auto max-w-container px-4 md:px-6">
            <h2 className="font-display text-2xl font-semibold text-ink md:text-3xl">Artikel Lainnya</h2>
            <div className="mt-8 grid gap-6 md:grid-cols-3">
              {related.map((item) => (
                <ArticleCard key={item.slug} article={item} />
              ))}
            </div>
          </div>
        </section>
      )}
    </PublicLayout>
  );
}
