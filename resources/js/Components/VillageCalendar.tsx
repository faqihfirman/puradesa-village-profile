import {
  addMonths,
  eachDayOfInterval,
  endOfMonth,
  endOfWeek,
  format,
  isSameDay,
  isSameMonth,
  isToday,
  startOfMonth,
  startOfWeek,
  subMonths,
} from 'date-fns';
import { id as localeId } from 'date-fns/locale';
import { CalendarOff, ChevronLeft, ChevronRight } from 'lucide-react';
import { useMemo, useState } from 'react';
import EventDetailModal from '@/Components/EventDetailModal';

type CalendarEvent = {
  name: string;
  date: string;
  startTime: string | null;
  endTime: string | null;
  location: string | null;
  description: string | null;
};

const WEEKDAYS = ['Min', 'Sen', 'Sel', 'Rab', 'Kam', 'Jum', 'Sab'];

export default function VillageCalendar({ events }: { events: CalendarEvent[] }) {
  const [cursor, setCursor] = useState(() => new Date());
  const [selectedDate, setSelectedDate] = useState(() => new Date());
  const [selectedEvent, setSelectedEvent] = useState<CalendarEvent | null>(null);

  const days = useMemo(() => {
    const start = startOfWeek(startOfMonth(cursor));
    const end = endOfWeek(endOfMonth(cursor));

    return eachDayOfInterval({ start, end });
  }, [cursor]);

  const eventsByDate = useMemo(() => {
    const map = new Map<string, CalendarEvent[]>();

    for (const event of events) {
      const list = map.get(event.date) ?? [];
      list.push(event);
      map.set(event.date, list);
    }

    return map;
  }, [events]);

  const selectedDateKey = format(selectedDate, 'yyyy-MM-dd');
  const selectedDateEvents = eventsByDate.get(selectedDateKey) ?? [];

  return (
    <div className="flex flex-col gap-4 lg:flex-row lg:items-stretch">
      <div className="overflow-hidden rounded-card border border-border bg-surface lg:w-2/3">
        <div className="flex items-center justify-between border-b border-border px-5 py-4 md:px-6">
          <button
            type="button"
            onClick={() => setCursor((prev) => subMonths(prev, 1))}
            aria-label="Bulan sebelumnya"
            className="flex h-9 w-9 items-center justify-center rounded-input text-ink hover:bg-background-alt"
          >
            <ChevronLeft className="h-5 w-5" />
          </button>
          <h3 className="font-display text-lg font-semibold capitalize text-ink">
            {format(cursor, 'MMMM yyyy', { locale: localeId })}
          </h3>
          <button
            type="button"
            onClick={() => setCursor((prev) => addMonths(prev, 1))}
            aria-label="Bulan berikutnya"
            className="flex h-9 w-9 items-center justify-center rounded-input text-ink hover:bg-background-alt"
          >
            <ChevronRight className="h-5 w-5" />
          </button>
        </div>

        <div className="grid grid-cols-7 border-b border-border">
          {WEEKDAYS.map((day) => (
            <div key={day} className="py-2 text-center text-xs font-semibold uppercase tracking-wider text-muted">
              {day}
            </div>
          ))}
        </div>

        <div className="grid grid-cols-7">
          {days.map((day) => {
            const key = format(day, 'yyyy-MM-dd');
            const dayEvents = eventsByDate.get(key) ?? [];
            const inMonth = isSameMonth(day, cursor);
            const today = isToday(day);
            const selected = isSameDay(day, selectedDate);

            return (
              <button
                key={key}
                type="button"
                onClick={() => setSelectedDate(day)}
                className={`flex min-h-[64px] flex-col items-center gap-1 border-b border-r border-border py-2 last:border-r-0 md:min-h-[76px] ${
                  inMonth ? 'bg-surface hover:bg-background-alt' : 'bg-background/60'
                } ${selected && !today ? 'bg-secondary-container/60 hover:bg-secondary-container/60' : ''}`}
              >
                <span
                  className={`inline-flex h-7 w-7 items-center justify-center rounded-full text-sm ${
                    today
                      ? 'bg-primary font-semibold text-on-primary'
                      : selected
                        ? 'font-semibold text-ink ring-2 ring-secondary'
                        : inMonth
                          ? 'text-ink'
                          : 'text-muted/50'
                  }`}
                >
                  {format(day, 'd')}
                </span>
                <span
                  className={`h-1.5 w-1.5 rounded-full ${dayEvents.length > 0 ? 'bg-secondary' : 'bg-transparent'}`}
                  aria-hidden="true"
                />
              </button>
            );
          })}
        </div>
      </div>

      <div className="flex flex-col rounded-card border border-border bg-surface p-5 lg:w-1/3">
        <h4 className="font-display text-base font-semibold capitalize text-ink">
          {format(selectedDate, 'EEEE, d MMMM yyyy', { locale: localeId })}
        </h4>

        {selectedDateEvents.length > 0 ? (
          <div className="mt-4 flex flex-col gap-2">
            {selectedDateEvents.map((event) => (
              <button
                key={`${event.name}-${event.date}`}
                type="button"
                onClick={() => setSelectedEvent(event)}
                className="flex items-center justify-between gap-2 rounded-input border border-border px-3 py-2.5 text-left hover:border-secondary hover:bg-background-alt"
              >
                <span className="truncate text-sm font-medium text-ink">{event.name}</span>
                {event.startTime && <span className="flex-shrink-0 text-xs text-muted">{event.startTime}</span>}
              </button>
            ))}
          </div>
        ) : (
          <div className="flex flex-1 flex-col items-center justify-center gap-2 py-6 text-center">
            <CalendarOff className="h-8 w-8 text-muted/60" />
            <p className="text-sm text-muted">Tidak ada kegiatan desa pada hari ini.</p>
          </div>
        )}
      </div>

      {selectedEvent && <EventDetailModal event={selectedEvent} onClose={() => setSelectedEvent(null)} />}
    </div>
  );
}
