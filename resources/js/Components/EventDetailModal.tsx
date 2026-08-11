import { CalendarDays, Clock, MapPin, X } from 'lucide-react';
import { useEffect } from 'react';
import { formatDate } from '@/lib/format';

type CalendarEvent = {
  name: string;
  date: string;
  startTime: string | null;
  endTime: string | null;
  location: string | null;
  description: string | null;
};

export default function EventDetailModal({ event, onClose }: { event: CalendarEvent; onClose: () => void }) {
  useEffect(() => {
    const handleKeyDown = (e: KeyboardEvent) => {
      if (e.key === 'Escape') onClose();
    };

    window.addEventListener('keydown', handleKeyDown);
    return () => window.removeEventListener('keydown', handleKeyDown);
  }, [onClose]);

  return (
    <div
      className="fixed inset-0 z-[60] flex items-center justify-center bg-ink/50 p-4"
      onClick={onClose}
      role="presentation"
    >
      <div
        className="w-full max-w-md rounded-card border border-black/5 bg-surface p-6 shadow-[0px_4px_12px_rgba(22,36,28,0.06)] md:p-8"
        role="dialog"
        aria-modal="true"
        aria-label={event.name}
        onClick={(e) => e.stopPropagation()}
      >
        <div className="flex items-start justify-between gap-4">
          <span className="inline-flex items-center gap-2 rounded-badge bg-secondary-container px-2.5 py-1 text-xs font-semibold text-on-secondary-container">
            <CalendarDays className="h-3.5 w-3.5" />
            {formatDate(event.date)}
          </span>
          <button
            type="button"
            onClick={onClose}
            aria-label="Tutup"
            className="flex h-8 w-8 flex-shrink-0 items-center justify-center rounded-full text-muted hover:bg-background-alt hover:text-ink"
          >
            <X className="h-5 w-5" />
          </button>
        </div>

        <h3 className="mt-4 font-display text-xl font-semibold text-ink md:text-2xl">{event.name}</h3>

        <div className="mt-3 flex flex-col gap-2">
          {event.startTime && (
            <div className="flex items-center gap-2 text-sm text-body">
              <Clock className="h-4 w-4 flex-shrink-0 text-secondary" />
              {event.endTime ? `${event.startTime} – ${event.endTime} WIB` : `${event.startTime} WIB`}
            </div>
          )}
          {event.location && (
            <div className="flex items-center gap-2 text-sm text-body">
              <MapPin className="h-4 w-4 flex-shrink-0 text-secondary" />
              {event.location}
            </div>
          )}
        </div>

        {event.description && <p className="mt-4 text-sm leading-relaxed text-body md:text-base">{event.description}</p>}
      </div>
    </div>
  );
}
