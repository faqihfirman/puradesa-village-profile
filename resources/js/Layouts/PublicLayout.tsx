import { Link, usePage } from '@inertiajs/react';
import { Mail, Menu, Phone, X } from 'lucide-react';
import { type ReactNode, useState } from 'react';
import { FacebookIcon, InstagramIcon, YoutubeIcon } from '@/Components/SocialIcons';
import { formatNumber } from '@/lib/format';
import type { SharedProps } from '@/types';

const NAV_ITEMS = [
  { label: 'Beranda', href: '/' },
  { label: 'Profil Desa', href: '/profil-desa' },
  { label: 'Artikel', href: '/artikel' },
  { label: 'Potensi & Wisata', href: '/potensi-wisata' },
  { label: 'Kontak', href: '/kontak' },
];

export default function PublicLayout({ children }: { children: ReactNode }) {
  const { props, url } = usePage<{ site: SharedProps['site']; village: SharedProps['village']; visitors: SharedProps['visitors'] }>();
  const { site, village, visitors } = props;
  const [menuOpen, setMenuOpen] = useState(false);

  return (
    <div className="flex min-h-screen flex-col bg-background">
      <header className="sticky top-0 z-50 border-b border-white/10 bg-primary">
        <div className="mx-auto flex max-w-container items-center justify-between px-4 py-4 md:px-6">
          <Link href="/" className="font-display text-lg font-bold text-on-primary">
            {village.name}
          </Link>

          <nav className="hidden items-center gap-8 md:flex">
            {NAV_ITEMS.map((item) => {
              const isActive = item.href === '/' ? url === '/' : url.startsWith(item.href);

              return (
                <Link
                  key={item.href}
                  href={item.href}
                  className={`font-display text-sm ${isActive ? 'font-semibold text-on-primary' : 'text-on-primary/80 hover:text-on-primary'}`}
                >
                  {item.label}
                </Link>
              );
            })}
          </nav>

          <button
            type="button"
            className="text-on-primary md:hidden"
            onClick={() => setMenuOpen((open) => !open)}
            aria-label="Buka menu navigasi"
            aria-expanded={menuOpen}
          >
            {menuOpen ? <X className="h-6 w-6" /> : <Menu className="h-6 w-6" />}
          </button>
        </div>

        {menuOpen && (
          <nav className="flex flex-col gap-1 border-t border-white/10 px-4 py-3 md:hidden">
            {NAV_ITEMS.map((item) => (
              <Link
                key={item.href}
                href={item.href}
                className="rounded-input px-2 py-2 font-display text-sm text-on-primary/90 hover:bg-white/10"
                onClick={() => setMenuOpen(false)}
              >
                {item.label}
              </Link>
            ))}
          </nav>
        )}
      </header>

      <main className="flex-1">{children}</main>

      <footer className="bg-primary text-on-primary">
        <div className="mx-auto grid max-w-container gap-10 px-4 py-16 md:grid-cols-4 md:px-6">
          <div className="flex flex-col gap-3">
            <span className="font-display text-lg font-bold">{village.officeName}</span>
            <p className="text-sm text-on-primary/70">{site.address}</p>
          </div>

          <div className="flex flex-col gap-3">
            <span className="font-display text-sm font-semibold uppercase tracking-wider text-on-primary/60">
              Tautan Cepat
            </span>
            {NAV_ITEMS.map((item) => (
              <Link key={item.href} href={item.href} className="text-sm text-on-primary/80 hover:text-on-primary">
                {item.label}
              </Link>
            ))}
          </div>

          <div className="flex flex-col gap-3">
            <span className="font-display text-sm font-semibold uppercase tracking-wider text-on-primary/60">
              Hubungi Kami
            </span>
            <a href={`tel:${site.phone}`} className="flex items-center gap-2 text-sm text-on-primary/80 hover:text-on-primary">
              <Phone className="h-4 w-4" /> {site.phone}
            </a>
            <a href={`mailto:${site.email}`} className="flex items-center gap-2 text-sm text-on-primary/80 hover:text-on-primary">
              <Mail className="h-4 w-4" /> {site.email}
            </a>
            <div className="flex items-center gap-3 pt-1">
              {site.social.facebook && (
                <a href={site.social.facebook} target="_blank" rel="noreferrer" aria-label="Facebook">
                  <FacebookIcon className="h-5 w-5 text-on-primary/80 hover:text-on-primary" />
                </a>
              )}
              {site.social.instagram && (
                <a href={site.social.instagram} target="_blank" rel="noreferrer" aria-label="Instagram">
                  <InstagramIcon className="h-5 w-5 text-on-primary/80 hover:text-on-primary" />
                </a>
              )}
              {site.social.youtube && (
                <a href={site.social.youtube} target="_blank" rel="noreferrer" aria-label="YouTube">
                  <YoutubeIcon className="h-5 w-5 text-on-primary/80 hover:text-on-primary" />
                </a>
              )}
            </div>
          </div>

          <div className="flex flex-col gap-2">
            <span className="font-display text-sm font-semibold uppercase tracking-wider text-on-primary/60">
              Pengunjung Hari Ini
            </span>
            <span className="font-display text-3xl font-bold text-accent">{formatNumber(visitors.today)}</span>
          </div>
        </div>

        <div className="border-t border-white/10 px-4 py-5 text-center text-xs text-on-primary/60 md:px-6">
          © {new Date().getFullYear()} Pemerintah {village.name}. Seluruh hak cipta dilindungi.
        </div>
      </footer>
    </div>
  );
}
