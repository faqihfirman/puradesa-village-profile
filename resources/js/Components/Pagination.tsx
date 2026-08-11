import { Link } from '@inertiajs/react';
import { ChevronLeft, ChevronRight } from 'lucide-react';
import type { PaginationLink } from '@/types';

const circleBase =
  'flex h-10 w-10 flex-shrink-0 items-center justify-center rounded-full font-display text-sm font-semibold transition-colors';

export default function Pagination({ links }: { links: PaginationLink[] }) {
  if (links.length === 0) return null;

  const [prev, ...rest] = links;
  const next = rest[rest.length - 1];
  const numbers = rest.slice(0, -1);

  const renderEdge = (link: PaginationLink, Icon: typeof ChevronLeft) => {
    if (!link.url) {
      return (
        <span key={link.label} className={`${circleBase} border border-border text-muted/50`}>
          <Icon className="h-4 w-4" />
        </span>
      );
    }

    return (
      <Link
        key={link.label}
        href={link.url}
        preserveScroll
        className={`${circleBase} border border-border text-body hover:border-secondary hover:text-primary`}
      >
        <Icon className="h-4 w-4" />
      </Link>
    );
  };

  return (
    <nav className="flex flex-wrap items-center justify-center gap-2 pt-10 md:pt-12" aria-label="Navigasi halaman">
      {renderEdge(prev, ChevronLeft)}

      {numbers.map((link, index) =>
        link.url ? (
          <Link
            key={index}
            href={link.url}
            preserveScroll
            className={`${circleBase} ${
              link.active
                ? 'bg-ink text-white'
                : 'border border-border text-body hover:border-secondary hover:text-primary'
            }`}
          >
            {link.label}
          </Link>
        ) : (
          <span key={index} className={`${circleBase} text-muted`}>
            {link.label}
          </span>
        )
      )}

      {renderEdge(next, ChevronRight)}
    </nav>
  );
}
