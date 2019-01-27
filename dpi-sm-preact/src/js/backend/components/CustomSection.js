import { h } from 'preact';

// components
import NavBar from './NavBar';
import SectionControls from './SectionControls';

const CustomSection = () => (
  <div class="dpi-sm-custom-section-options uk-animation-slide-bottom-small">
    <SectionControls />
    <div class="uk-card uk-card-default uk-background-muted">
      <NavBar />
    </div>
  </div>
);

export default CustomSection;
