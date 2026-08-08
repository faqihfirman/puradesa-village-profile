export type SharedProps = {
  site: {
    address: string;
    phone: string;
    whatsapp: string | null;
    email: string;
    officeHours: { weekday: string; weekend: string };
    coordinates: { lat: number; lng: number };
    googleMapsUrl: string | null;
    social: { facebook?: string; instagram?: string; youtube?: string };
  };
  village: {
    name: string;
    officeName: string;
    district: string;
    regency: string;
  };
  visitors: { today: number };
  flash: { success?: string; error?: string };
};

export type Article = {
  slug: string;
  title: string;
  excerpt: string;
  coverUrl: string | null;
  category: { name: string; color: string } | null;
  authorName: string;
  publishedAt: string | null;
};

export type HomeProps = {
  hero: {
    title: string;
    subtitle: string;
    ctaPrimary: { label: string; url: string };
    ctaSecondary: { label: string; url: string };
    imageUrl: string | null;
  };
  villageHead: {
    name: string;
    position: string;
    message: string;
    photoUrl: string | null;
  } | null;
  stats: {
    population: number;
    families: number;
    hamlets: number;
    areaSize: number;
    areaUnit: string;
  } | null;
  latestArticles: Article[];
};
