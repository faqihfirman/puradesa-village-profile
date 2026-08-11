export type SharedProps = {
  village: {
    name: string;
    officeName: string;
    district: string;
    regency: string;
    contact: {
      address: string;
      phone: string;
      email: string;
      mapsUrl: string;
      hours: { weekday: string; weekend: string };
      social: { facebook: string | null; instagram: string | null; youtube: string | null };
    };
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

export type PaginationLink = { url: string | null; label: string; active: boolean };

export type Paginated<T> = {
  data: T[];
  links: PaginationLink[];
  current_page: number;
  last_page: number;
};

export type Category = { name: string; slug: string };

export type ArticleDetail = {
  slug: string;
  title: string;
  content: string;
  coverUrl: string | null;
  category: { name: string; slug: string; color: string } | null;
  authorName: string;
  publishedAt: string | null;
};

export type EconomicPotential = {
  slug: string;
  title: string;
  description: string;
  sector: string;
  sectorLabel: string;
  imageUrl: string | null;
};

export type EconomicPotentialDetail = {
  slug: string;
  title: string;
  content: string;
  imageUrl: string | null;
  sector: string;
  sectorLabel: string;
  mapsUrl: string | null;
};

export type SectorOption = { label: string; value: string };

export type DestinationCard = {
  slug: string;
  name: string;
  shortDescription: string;
  coverUrl: string | null;
  categoryLabel: string;
  hamletName: string;
};

export type DestinationDetail = {
  slug: string;
  name: string;
  description: string;
  coverUrl: string | null;
  categoryLabel: string;
  hamletName: string;
  mapsUrl: string;
};

export type ArticlesIndexProps = {
  featured: Article | null;
  categories: Category[];
  activeCategory: string | null;
  articles: Paginated<Article>;
};

export type ArticleShowProps = {
  article: ArticleDetail;
  related: Article[];
};

export type UmkmIndexProps = {
  slides: EconomicPotential[];
  sectors: SectorOption[];
  activeSector: string | null;
  potentials: Paginated<EconomicPotential>;
};

export type UmkmShowProps = {
  potential: EconomicPotentialDetail;
  related: EconomicPotential[];
};

export type DestinationShowProps = {
  destination: DestinationDetail;
  related: DestinationCard[];
};

export type DestinationsIndexProps = {
  slides: DestinationCard[];
  destinations: Paginated<DestinationCard>;
};

export type PopulationCategory = { label: string; total: number };
export type PopulationByGender = { label: string; male: number; female: number };

export type ProfileProps = {
  profile: {
    historyContent: string;
    foundedYear: number;
    illustrationUrl: string | null;
    vision: string;
    areaSize: number;
    areaUnit: string;
    altitude: number;
    altitudeUnit: string;
    totalPopulation: number;
    totalFamilies: number;
    populationDensity: number;
    populationByReligion: PopulationCategory[];
    populationByMaritalStatus: PopulationCategory[];
    populationByEducation: PopulationByGender[];
    populationByOccupation: PopulationByGender[];
    populationByAgeGroup: PopulationByGender[];
    mapCenterLat: number;
    mapCenterLng: number;
    mapZoom: number;
  };
  missions: { title: string; description: string }[];
  officials: {
    name: string;
    position: string;
    level: number;
    photoUrl: string | null;
    phone: string | null;
  }[];
};

export type HomeProps = {
  hero: {
    title: string;
    subtitle: string;
    ctaPrimary: { label: string; url: string };
  };
  villageHead: {
    name: string;
    position: string;
    message: string;
    photoUrl: string | null;
  } | null;
  events: {
    name: string;
    date: string;
    startTime: string | null;
    endTime: string | null;
    location: string | null;
    description: string | null;
  }[];
  latestArticles: Article[];
};
