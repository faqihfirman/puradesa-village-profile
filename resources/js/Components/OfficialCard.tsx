import { Phone } from 'lucide-react';

function initials(name: string): string {
  return name
    .split(' ')
    .filter(Boolean)
    .slice(0, 2)
    .map((word) => word[0]?.toUpperCase())
    .join('');
}

export default function OfficialCard({
  official,
  size = 'md',
}: {
  official: { name: string; position: string; photoUrl: string | null; phone: string | null };
  size?: 'lg' | 'md';
}) {
  const photoSize = size === 'lg' ? 'w-40 md:w-48' : 'w-28 md:w-32';

  return (
    <div className="flex flex-col items-center gap-3 rounded-card border border-border bg-surface p-5 text-center transition-colors hover:border-secondary">
      <div className={`aspect-[3/4] ${photoSize} overflow-hidden rounded-input bg-secondary-container`}>
        {official.photoUrl ? (
          <img src={official.photoUrl} alt={official.name} className="h-full w-full object-cover" loading="lazy" />
        ) : (
          <div className="flex h-full w-full items-center justify-center font-display text-2xl font-semibold text-secondary">
            {initials(official.name)}
          </div>
        )}
      </div>
      <div>
        <p className="font-display text-base font-semibold text-ink">{official.name}</p>
        <p className="text-sm text-muted">{official.position}</p>
      </div>
      {official.phone && (
        <a href={`tel:${official.phone}`} className="flex items-center gap-1.5 text-xs text-primary hover:underline">
          <Phone className="h-3.5 w-3.5" /> {official.phone}
        </a>
      )}
    </div>
  );
}
