import { async, ComponentFixture, TestBed } from '@angular/core/testing';

import { DaftarKategoriComponent } from './daftar-kategori.component';

describe('DaftarKategoriComponent', () => {
  let component: DaftarKategoriComponent;
  let fixture: ComponentFixture<DaftarKategoriComponent>;

  beforeEach(async(() => {
    TestBed.configureTestingModule({
      declarations: [ DaftarKategoriComponent ]
    })
    .compileComponents();
  }));

  beforeEach(() => {
    fixture = TestBed.createComponent(DaftarKategoriComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
