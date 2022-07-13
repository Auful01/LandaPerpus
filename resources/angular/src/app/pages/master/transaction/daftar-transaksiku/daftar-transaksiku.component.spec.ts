import { async, ComponentFixture, TestBed } from '@angular/core/testing';

import { DaftarTransaksikuComponent } from './daftar-transaksiku.component';

describe('DaftarTransaksikuComponent', () => {
  let component: DaftarTransaksikuComponent;
  let fixture: ComponentFixture<DaftarTransaksikuComponent>;

  beforeEach(async(() => {
    TestBed.configureTestingModule({
      declarations: [ DaftarTransaksikuComponent ]
    })
    .compileComponents();
  }));

  beforeEach(() => {
    fixture = TestBed.createComponent(DaftarTransaksikuComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
