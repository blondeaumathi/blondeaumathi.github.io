// config.js
import { createClient } from 'https://cdn.jsdelivr.net/npm/@supabase/supabase-js@2/+esm'

const SUPABASE_URL = 'https://xsybbjmaoiefnzkewmtz.supabase.co'
const SUPABASE_ANON_KEY = 'eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJpc3MiOiJzdXBhYmFzZSIsInJlZiI6InhzeWJiam1hb2llZm56a2V3bXR6Iiwicm9sZSI6ImFub24iLCJpYXQiOjE3NTkzMDI0NzQsImV4cCI6MjA3NDg3ODQ3NH0.tlfv5q9sVDj49x1BhHDN6xU4MqppMxGxGeLLbqRfd_s'

// On exporte la variable 'supabase' pour pouvoir l'importer ailleurs
export const supabase = createClient(SUPABASE_URL, SUPABASE_ANON_KEY)